<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Buildablox Controller
 *
 * This controller displays the list of current blox in the
 * application/toolblox folder and also allows the user to create new blox modules
 * 
 */
class Buildablox extends Admin_Controller
{
    /**
     * @var Array The options from the /config/buildablox.php file
     */
    private $options;

    //---------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('builder');
        $this->load->helper('file');
        $this->load->helper('blox');
        $this->load->config('buildablox');

        $this->options = $this->config->item('buildablox');
        if (isset($this->options['form_error_delimiters'])
            && is_array($this->options['form_error_delimiters'])
            && count($this->options['form_error_delimiters']) == 2
           ) {
            $this->form_validation->set_error_delimiters($this->options['form_error_delimiters'][0], $this->options['form_error_delimiters'][1]);
        }

        Modules::register_asset('/assets/css/buildablox.css');
        Modules::register_asset('/assets/js/buildablox.js');

    }

    /**
     * Display a list of installed modules
     *
     * Includes the options to create a new module or context and delete
     * existing modules.
     *
     * @return void
     */
    public function index()
    {
        $modules = Modules::list_modules(true);
        $mod_migrations = $this->get_db_versions();

        $configs = array();


        foreach ($modules as $module) {
            $configs[$module] = Modules::config($module);

            if (! isset($configs[$module]['name'])) {
                $configs[$module]['name'] = ucwords($module);
            } elseif (strpos($configs[$module]['name'], 'lang:') === 0) {
                // If the name is configured, check to see if it is a lang entry
                // and, if it is, pull it from the application_lang file.
                $configs[$module]['name'] = lang(str_replace('lang:', '', $configs[$module]['name']));
            }

            if (isset($mod_migrations[$module]) )
                $configs[$module]['dbversions'] = $mod_migrations[$module];

        }
        // Sort the module list (by the name of each module's folder)
        ksort($configs);

        // Check that the modules folder is writable
        Template::set('writable', $this->checkWritable());
        Template::set('modules', $configs);
        //Template::set('toolbar_title', lang('mb_toolbar_title_index'));

        $data = array('page_title'=>lang('mb_page_title'),
         'page_subtitle'=>'',
         'page_breadcrumb'=>lang('mb_breadcrumb_title'));

        $data['writable'] = $this->checkWritable();
        $data['modules'] = $configs;

        foreach( $data as $key => $value )
            Template::set($key, $value);
        Template::render();
    }


    //--------------------------------------------------------------------
    // Create module blox
    //--------------------------------------------------------------------

    /**
     * Display the form which allows the user to create a module blox.
     *
     * @return void
     */
    public function create_module($fields = 0)
    {
        //$this->auth->restrict('Modules.Add');

        $hide_form = false;
        $this->field_total = $fields;

        // Validation failed
        if ($this->validate_form($this->field_total) == false) {
            // Display the buildablox_form
            $this->prepareModuleForm($this->field_total, isset($_POST['build']));
        } elseif ($this->input->post('module_db') == 'existing'
            && $this->field_total == 0
        ) {
            // Validation Passed, Use existing DB, need to detect the fields.
            //
            // If the table name includes the prefix, remove the prefix
            $_POST['table_name'] = preg_replace("/^".$this->db->dbprefix."/", "", $this->input->post('table_name'));

            // Read the fields from the db table and pass them back to the form
            $table_fields = $this->table_info($this->input->post('table_name'));
            $num_fields   = is_array($table_fields) ? count($table_fields) : 0;

            // $num_fields includes the primary key, field_total doesn't
            $fieldTotal = $num_fields > 0 ? $num_fields - 1 : $this->field_total;
            $formError  = false;

            // If the table wasn't found, log/set an error message
            if (! empty($_POST) && $num_fields == 0) {
                $formError = true;
                $error_message = lang('mb_module_table_not_exist');
                log_message('error', "buildablox: {$error_message}");
                Template::set('error_message', $error_message);
            }

            Template::set('existing_table_fields', $table_fields);

            // Display the buildablox_form
            $this->prepareModuleForm($fieldTotal, $formError);
        } else {
            // Validation passed and ready to proceed
            $this->build_module($this->field_total);
            log_activity((int) $this->current_user->id, lang('mb_act_create') . ': ' . $this->input->post('module_name') . ' : ' . $this->input->ip_address(), 'buildablox');

            Template::set_view('output');
        }

        $data = array('page_title'=>lang('mb_page_title'),
         'page_subtitle'=>'',
         'page_breadcrumb'=>lang('mb_breadcrumb_title'));

        $data['writable'] = $this->checkWritable();
 
        foreach( $data as $key => $value )
            Template::set($key, $value);
        Template::render();
    }

    /**
     * Delete a Blox and all of its files.
     *
     * @return void
     */
    public function delete()
    {
        // If there's no module to delete, redirect
        $module_name = $this->input->post('module');
        if (empty($module_name)) {
            redirect('/buildablox');
        }

        //$this->auth->restrict('Modules.Delete');

        // Remove the module's data and permissions from the database
        if ($this->deleteModuleData($module_name) === false) {
            // Something went wrong while trying to delete the data
            Template::set_message(lang('mb_delete_trans_false'), $this->db->error, 'error');

            redirect('/buildablox');
        }

        // Data deleted successfully, now try to remove the files.
        $this->load->helper('file');
        if (delete_files(Modules::path($module_name), true)) {
            @rmdir(Modules::path("{$module_name}/"));

            log_activity((int) $this->auth->user_id(), lang('mb_act_delete') . ": {$module_name} : " . $this->input->ip_address(), 'buildablox');
            Template::set_message(lang('mb_delete_success'), 'success');
        } else {
            // Database removal succeeded, but the files may still be present
            Template::set_message(lang('mb_delete_success') . lang('mb_delete_success_db_only'), 'info');
        }

        redirect('/buildablox');
    }

    //--------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------

    /**
     * Delete the data for a module
     *
     * Removes migration information, permissions based on the name of the
     * module, and any tables returned by the module's model's get_table()
     * method.
     *
     * @todo Use the migration library instead of doing everything directly.
     *
     * @param string $moduleName The name of the module
     *
     * @return bool    true if the data is removed, false on error
     */
    private function deleteModuleData($moduleName)
    {
        $this->load->dbforge();
        $this->db->trans_begin();
   
        // Drop the Migration record
        $moduleNameLower = preg_replace("/[ -]/", "_", strtolower($moduleName));
        
        $this->db->delete('schema_version', array('type' => $moduleNameLower . '_'));
        
        // Get any permission ids
        $this->load->model('securinator/sec_permission_model');
        $permissionKey = $this->sec_permission_model->get_key();
        $permissionIds = $this->sec_permission_model->select($permissionKey)
                                                ->like('name', $moduleName . '.', 'after')
                                                ->find_all();

        // Undo any permissions that exist, from the roles as well
        if (! empty($permissionIds)) {
            foreach ($permissionIds as $row) {
                $this->sec_permission_model->delete($row->permission_id);
            }
        }

        // Check whether there is a model to drop (a model should have a table
        // which may require dropping)
        $modelName = "{$moduleName}_model";
        if (Modules::file_path($moduleName, 'models', "{$modelName}.php")) {
            // Drop the table
            $this->load->model("{$moduleName}/{$modelName}", 'mt');
            $mtTableName = $this->mt->get_table();
            // TODO disallow removal of core tables
            // If the model has a table and it exists in the database, drop it
            if (! empty($mtTableName) && $this->db->table_exists($mtTableName)) {
                $this->dbforge->drop_table($mtTableName);
            }
        }

        // Complete the database transaction or roll it back
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    /**
     * Prepare the variables used for the buildablox_form and set the view
     *
     * @todo Ideally the field type variables would be set at a higher level for
     * consistent use throughout the buildablox
     *
     * @param int $fieldTotal The number of fields to add to the table
     * @param bool $formError Set to true if an error has occurred on the form
     *
     * @return void
     */
    private function prepareModuleForm($fieldTotal, $formError)
    {
        $this->load->model('securinator/sec_role_model');
        $this->sec_role_model->select(array('role', 'role_name'))
                         ->where('deleted', 0)
                         ->order_by('role_name');

        $this->load->library('Modulebuilder');
        $boolFieldTypes = array_merge($this->modulebuilder->getBooleanTypes(), array('BIT', 'BOOL', 'TINYINT'));
        $listFieldTypes = $this->modulebuilder->getListTypes();
        $textFieldTypes = $this->modulebuilder->getTextTypes();
        $dbFieldTypes = array();
        foreach (array_keys($this->modulebuilder->getDatabaseTypes()) as $key) {
            $dbFieldTypes[$key] = $key;
        }

        Template::set('defaultRoleWithFullAccess','admin');
        Template::set('availableContexts', $this->options['controller_types']);
        Template::set('boolFieldTypes', $boolFieldTypes);
        Template::set('db_field_types', $dbFieldTypes);
        Template::set('field_numbers', range(0, 20));
        Template::set('field_total', $fieldTotal);
        Template::set('form_action_options', $this->options['form_action_options']);
        Template::set('form_error', $formError);
        Template::set('listFieldTypes', $listFieldTypes);
        Template::set('roles', $this->sec_role_model->as_array()->find_all());
        Template::set(
            'textarea_editors',
            array(
                ''          => 'None',
                'ckeditor'  => 'CKEditor',
                'tinymce'   => 'TinyMCE',
            )
        );
        Template::set('textFieldTypes', $textFieldTypes);
        Template::set(
            'truefalse',
            array(
                'false' => 'False',
                'true' => 'True',
            )
        );
        Template::set('validation_limits', $this->options['validation_limits']);
        Template::set('validation_rules', $this->options['validation_rules']);
        Template::set(
            'view_field_types',
            array(
                'input'    => 'INPUT',
                'checkbox' => 'CHECKBOX',
                'image'    => 'IMAGE',
                'password' => 'PASSWORD',
                'radio'    => 'RADIO',
                'select'   => 'SELECT',
                'textarea' => 'TEXTAREA',
            )
        );

        Template::set_view('modulebuilder_form');
    }

    /**
     * Validate the buildablox form.
     *
     * @param int $field_total The number of fields to add to the table
     *
     * @return bool Whether the form data was valid or not
     */
    private function validate_form($field_total = 0)
    {
        $this->form_validation->set_rules("contexts_public", 'lang:mb_contexts_public', "trim|is_numeric");
        $this->form_validation->set_rules("module_db", 'lang:mb_module_db', "trim|alpha");
        $this->form_validation->set_rules("form_action_create", 'lang:mb_form_action_create', "trim|is_numeric");
        $this->form_validation->set_rules("form_action_delete", 'lang:mb_form_action_delete', "trim|is_numeric");
        $this->form_validation->set_rules("form_action_edit", 'lang:mb_form_action_edit', "trim|is_numeric");
        $this->form_validation->set_rules("form_action_view", 'lang:mb_form_action_view', "trim|is_numeric");
        $this->form_validation->set_rules("form_error_delimiters", 'lang:mb_form_err_delims', "required|trim");
        $this->form_validation->set_rules("module_description", 'lang:mb_form_mod_desc', "trim|required");
        $this->form_validation->set_rules("module_name", 'lang:mb_form_mod_name', "trim|required|alpha_dash");  //blox_modulename_check()");
        $this->form_validation->set_rules("role_id", 'lang:mb_form_role_id', "trim");

        // If there's no database table, don't use the table validation
        if ($this->input->post('module_db')) {
            $this->form_validation->set_rules("table_name", 'lang:mb_form_table_name', "trim|required|alpha_dash");

            // If it's a new table, extra validation is required
            if ($this->input->post('module_db') == 'new') {
                $this->form_validation->set_rules("primary_key_field", 'lang:mb_form_primarykey', "required|trim|alpha_dash");
                $this->form_validation->set_rules("soft_delete_field", 'lang:mb_soft_delete_field', "trim|alpha_dash");
                $this->form_validation->set_rules("created_field", 'lang:mb_form_created_field', "trim|alpha_dash");
                $this->form_validation->set_rules("modified_field", 'lang:mb_form_modified_field', "trim|alpha_dash");
                $this->form_validation->set_rules('deleted_by_field', 'lang:mb_deleted_by_field', 'trim|alpha_dash');
                $this->form_validation->set_rules('created_by_field', 'lang:mb_form_created_by_field', 'trim|alpha_dash');
                $this->form_validation->set_rules('modified_by_field', 'lang:mb_form_modified_by_field', 'trim|alpha_dash');
                // textarea_editor seems to be gone...
                //$this->form_validation->set_rules("textarea_editor", 'lang:mb_form_text_ed', "trim|alpha_dash");
            } elseif ($this->input->post('module_db') == 'existing'
                && $field_total > 0
            ) {
                // If it's an existing table, the primary key validation is required
                $this->form_validation->set_rules("primary_key_field", 'lang:mb_form_primarykey', "required|trim|alpha_dash");
            }

            // No need to do any of the below on every iteration of the loop
            $lang_field_details = lang('mb_form_field_details') . ' ';

            $this->load->library('Modulebuilder');

            // Make sure the length field is required if the DB Field type
            // requires a length
            $no_length = array_merge(
                $this->modulebuilder->getObjectTypes(),
                $this->modulebuilder->getBooleanTypes(),
                $this->modulebuilder->getDateTypes(),
                $this->modulebuilder->getTimeTypes()
            );

            $optional_length = array_diff(
                $this->modulebuilder->getIntegerTypes(),
                $this->modulebuilder->getBooleanTypes()
            );

            for ($counter = 1; $field_total >= $counter; $counter++) {
                $field_details_label = $lang_field_details . $counter . ' :: ';

                // We don't define the validation labels with 'lang:' in this
                // loop because we don't want to create language entries for
                // every possible $counter value

                // Better to do it this way round as this statement will be
                // fullfilled more than the one below
                if ($counter != 1) {
                    $this->form_validation->set_rules("view_field_label$counter", $field_details_label . lang('mb_form_label'), 'trim|alpha_numeric_spaces');
                } else {
                    // At least one field is required in the form
                    $this->form_validation->set_rules("view_field_label$counter", $field_details_label . lang('mb_form_label'), 'trim|required|alpha_numeric_spaces');
                }

                $label = $this->input->post("view_field_label$counter");
                $name_required = empty($label) ? '' : 'required|';

                $fieldinfo = json_encode(array($counter, $field_total));
                $this->form_validation->set_rules("view_field_name$counter", $field_details_label . lang('mb_form_fieldname'), "trim|{$name_required}blox_fieldno_check[$fieldinfo]");
                $this->form_validation->set_rules("view_field_type$counter", $field_details_label . lang('mb_form_type'), "trim|required|alpha");
                $this->form_validation->set_rules("db_field_type$counter", $field_details_label . lang('mb_form_dbtype'), "trim|alpha");

                $field_type = $this->input->post("db_field_type$counter");
                $db_len_required = '';
                if (! empty($label)
                    && ! in_array($field_type, $no_length)
                    && ! in_array($field_type, $optional_length)
                ) {
                    $db_len_required = '|required';
                }

                $this->form_validation->set_rules("db_field_length_value$counter", $field_details_label . lang('mb_form_length'), "trim{$db_len_required}");
                $this->form_validation->set_rules('validation_rules'.$counter.'[]', $field_details_label . lang('mb_form_rules'), 'trim');
            }
        }

        return $this->form_validation->run();
    }

    /**
     * Get the structure and details for the fields in the specified DB table
     *
     * @param string $table_name Name of the table to check
     *
     * @return mixed An array of fields or false if the table does not exist
     */
    private function table_info($table_name)
    {
        $newfields = array();

        // Check whether the table exists in this database
        if (! $this->db->table_exists($table_name)) {
            return false;
        }

        $fields = $this->db->field_data($table_name);

        // There may be something wrong or the database driver may not return
        // field data
        if (empty($fields)) {
            return false;
        }

        foreach ($fields as $field) {
            $max_length = null;
            $type = '';
            if (isset($field->type)) {
                if (strpos($field->type, "(")) {
                    list($type, $max_length) = explode("--", str_replace("(", "--", str_replace(")", "", $field->type)));
                } else {
                    $type = $field->type;
                }
            }

            $values = '';
            if (isset($field->max_length)) {
                if (is_numeric($field->max_length)) {
                    $max_length = $field->max_length;
                } else {
                    $values = $field->max_length;
                }
            }

            /* set some defaults for Date / datetime */
            if (strtoupper($type)=='DATE')
                $max_length = '10';

            else if (strtoupper($type)=='DATETIME')
                $max_length = '39';
                
            $newfields[] = array(
                'name'          => isset($field->name) ? $field->name : '',
                'type'          => strtoupper($type),
                'max_length'    => $max_length == null ? '' : $max_length,
                'values'        => $values,
                'primary_key'   => isset($field->primary_key) && $field->primary_key == 1 ? 1 : 0,
                'default'       => isset($field->default) ? $field->default : null,
            );
        }

        return $newfields;
    }

    /**
     * Handles the heavy-lifting of building a module from ther user's specs.
     *
     * @param int $field_total The number of fields to add to the table
     *
     * @return void
     */
    private function build_module($field_total = 0)
    {
        $action_names           = $this->input->post('form_action');
        $contexts               = $this->input->post('contexts');
        $db_required            = $this->input->post('module_db');
        $form_error_delimiters  = explode(',', $this->input->post('form_error_delimiters'));
        $module_description     = $this->input->post('module_description');
        $module_name            = $this->input->post('module_name');
        $entity_1 = $this->input->post('entity_name');
        $entity_2 = $this->input->post('entity_plural');
        $primary_key_field      = $this->input->post('primary_key_field');
        $role_id                = $this->input->post('role_id');
        $table_name             = strtolower(preg_replace("/[ -]/", "_", $this->input->post('table_name')));
        $table_as_field_prefix  = (bool) $this->input->post('table_as_field_prefix');

        $logUser        = $this->input->post('log_user') == 1;
        $useCreated     = $this->input->post('use_created') == 1;
        $useModified    = $this->input->post('use_modified') == 1;
        $usePagination  = $this->input->post('use_pagination') == 1;
        $useSoftDeletes = $this->input->post('use_soft_deletes') == 1;

        $created_field      = $this->input->post('created_field') ?: 'created_on';
        $created_by_field   = $this->input->post('created_by_field') ?: 'created_by';
        $soft_delete_field  = $this->input->post('soft_delete_field') ?: 'deleted';
        $deleted_by_field   = $this->input->post('deleted_by_field') ?: 'deleted_by';
        $modified_field     = $this->input->post('modified_field') ?: 'modified_on';
        $modified_by_field  = $this->input->post('modified_by_field') ?: 'modified_by';

        $textarea_editor = $this->input->post('textarea_editor');

        if ($primary_key_field == '') {
            $primary_key_field = $this->options['primary_key_field'];
        }

        if (! is_array($form_error_delimiters)
            || count($form_error_delimiters) != 2
        ) {
            $form_error_delimiters = $this->options['$form_error_delimiters'];
        }

        $controller_name = preg_replace("/[ -]/", "_", $module_name);
        $module_name_lower = strtolower($controller_name);

        $this->load->library('Modulebuilder');
        $file_data = $this->modulebuilder->buildFiles(
            array(
                'action_names'          => $action_names,
                'contexts'              => $contexts,
                'controller_name'       => $controller_name,
                'created_by_field'      => $created_by_field,
                'created_field'         => $created_field,
                'db_required'           => $db_required,
                'deleted_by_field'      => $deleted_by_field,
                'entity_name_single'    => $entity_1,
                'entity_name_single_lower' => strtolower($entity_1),
                'entity_name_plural'    => $entity_2,
                'entity_name_plural_lower' => strtolower($entity_2),
                'field_total'           => $field_total,
                'form_error_delimiters' => $form_error_delimiters,
                'logUser'               => $logUser,
                'modified_by_field'     => $modified_by_field,
                'modified_field'        => $modified_field,
                'module_description'    => $module_description,
                'module_name'           => $module_name,
                'module_name_lower'     => $module_name_lower,
                'primary_key_field'     => $primary_key_field,
                'role_id'               => $role_id,
                'soft_delete_field'     => $soft_delete_field,
                'table_as_field_prefix' => $table_as_field_prefix,
                'table_name'            => $table_name,
                'textarea_editor'       => $textarea_editor,
                'useCreated'            => $useCreated,
                'useModified'           => $useModified,
                'usePagination'         => $usePagination,
                'useSoftDeletes'        => $useSoftDeletes,
            )
        );

        // Make the variables available to the view file
        $data['module_name']       = $module_name;
        $data['controller_name']   = $controller_name;
        $data['module_name_lower'] = $module_name_lower;
        $data['table_name']        = empty($table_name) ? $module_name_lower : $table_name;

        $data = $data + $file_data;

        // Load the migrations library
        $this->load->library('Migrations');
              
        // Run the migration install routine
        if ($this->migrations->install($data['module_name_lower'].'_')) {
            $data['mb_migration_result'] = 'mb_out_tables_success';
        } else {
            $data['mb_migration_result'] = 'mb_out_tables_error';
        }

        Template::set($data);
    }


    /**
     * Get all db versions available for the modules
     *
     * @return array Array of available versions for each module
     */
    private function get_db_versions()
    {
        $modules = Modules::files(null, 'migrations');
        if ($modules === false) {
            return false;
        }

        // Sort modules by key (module directory name)
        ksort($modules);

        // Get the installed version of all of the modules (modules which have
        // not been installed will not be included)
        $this->load->library('Migrations');
        $installedVersions = $this->migrations->getModuleVersions();
        $modVersions = array();

        // Add the migration data for each module
        foreach ($modules as $module => &$mod) {
            if (! array_key_exists('migrations', $mod)) {
                continue;
            }

            // Sort module migrations in reverse order
            arsort($mod['migrations']);

            /**
             * @internal Calculating the latest version from the migration list
             * saves ~20% of the load time when a lot of modules (tested with >
             * 50) are listed. However, it requires the controller to know more
             * about the format of the migration filenames than may be desirable.
             * If that is the case, the 'latest_version' key below can be
             * populated with the result of:
             * $this->migrations->getVersion("{$module}_", true)
             */

            // Add the installed version, latest version, and list of migrations
            $modVersions[$module] = array(
                'installed' => isset($installedVersions["{$module}_"]) ? $installedVersions["{$module}_"] : 0,
                'latest'    => intval(substr(current($mod['migrations']), 0, 3), 10),
                'migrations'        => $mod['migrations'],
            );
        }

        return $modVersions;
    }


    /* domigrate */
    function domigrate($ver) {
            $ret='';
            // Load the migrations library
            $this->load->library('Migrations');

            $config['migration_enabled'] = true;
            $mod = $this->input->post('module');
            $type = strtolower($mod.'_');
            // Run the migration install routine
            if ($this->migrations->install($type)) {
                $ret = 'mb_out_tables_success';
                $this->migrations->updateVersion($type, $ver);
            } else {
                $ret = 'mb_out_tables_error';
            }
            $result = $this->migrations->version($ver, $type);
            $errorMessage = $this->migrations->getErrorMessage();
            if ($result !== false && strlen($errorMessage) == 0) {
                if ($result === 0) {
                    Template::set_message(lang('migrations_uninstall_success'), 'success');

                } else {
                    Template::set_message(sprintf(lang('migrations_migrate_success'), $result), 'success');
                }
            } else {
                log_message(lang('migrations_migrate_error') . "\n{$errorMessage}", 'error');
                Template::set_message(lang('migrations_migrate_error') . "<br />{$errorMessage}", 'error');
            }
            
            $this->config->set_item('migration_enabled', 'false');
            
            redirect('buildablox');
        
}

    /**
     * Verify that the Modules folder is writable
     *
     * @return bool    true if the folder is writable, else false
     */
    private function checkWritable()
    {
        return is_writable($this->options['output_path']);
    }


 }
