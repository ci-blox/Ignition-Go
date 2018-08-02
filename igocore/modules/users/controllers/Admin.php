<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Admin controller
 * @created on : 
 * @author :
 * Copyright {year}
 *
 */
class Admin extends Admin_Controller
{
    protected $permissionCreate = 'App.Users.Add';
    protected $permissionDelete = 'App.Users.Manage';
    protected $permissionEdit   = 'App.Users.Manage';
    protected $permissionView   = 'App.Users.View';

    /**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		 $this->load->library('securinator/Auth'); $this->load->model('users/user_model');
        $this->lang->load('usermaint');
		
			Modules::register_asset('flick/jquery-ui-1.8.13.custom.css');
			Modules::register_asset('jquery-ui-1.8.13.min.js');
			Modules::register_asset('jquery-ui-timepicker.css');
			Modules::register_asset('jquery-ui-timepicker-addon.js'); Template::set_theme('backend'); $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
	}

	/**
	 * Display a list of users.
	 *
	 * @return void
	 */
	public function index($offset = 0)
	{
   		if ($this->auth->is_logged_in() === false) {
    		Template::redirect('/admin/check/login');
 		}
		
		$data = array('page_title'=>lang('usermaint_area_title'),
         'page_subtitle'=>lang('usermaint_list'),
         'page_breadcrumb'=>lang('usermaint_manage'));

		// Deleting anything?
		if (isset($_POST['delete'])) {
            //$this->auth->restrict($this->permissionDelete);
			$checked = $this->input->post('checked');
			if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

				$result = true;
				foreach ($checked as $pid) {
					$deleted = $this->user_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
				}
				if ($result) {
					Template::set_message(count($checked) . ' ' . lang('usermaint_delete_success'), 'success');
				} else {
					Template::set_message(lang('usermaint_delete_failure') . $this->user_model->error, 'error');
				}
			}
		}
        $pagerUriSegment = 4;
        $pagerBaseUrl = site_url('/admin/users/') . '/';
               $pager = array(
            'base_url'          => $pagerBaseUrl,
            'total_rows'        => $this->user_model->count_all(),
            //'per_page'          => $this->config->item('per_page'),
			'per_page'			=> 5,
            'uri_segment'       => $pagerUriSegment,
            'num_links'         => 9,
            'use_page_numbers'  => FALSE,
			'page_query_string' => FALSE
        );
        
        $this->load->library('pagination');
        $this->pagination->initialize($pager);
        $this->user_model->limit($pager['per_page'], $offset);
        $data['total']          = $pager['total_rows'];
        $data['pagination']     = $this->pagination->create_links();
        $data['number']         = (int)$this->uri->segment($pagerUriSegment) + 1;

        $data['records'] = $this->user_model->find_all();
        foreach( $data as $key => $value )
            Template::set($key, $value);
        
		Template::render();
	}
    
    /**
	 * Create a user
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict($this->permissionCreate);
        
		$data = array('page_title'=>lang('usermaint_area_title'),
         'page_subtitle'=>lang('usermaint_action_create'),
         'page_breadcrumb'=>lang('usermaint_manage'));

		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_usermaint()) {
				log_activity($this->auth->user_id(), lang('usermaint_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'usermaint');
				Template::set_message(lang('usermaint_create_success'), 'success');

				redirect('/admin/users/');
			}

            // Not validation error
			if ( ! empty($this->user_model->error)) {
				Template::set_message(lang('usermaint_create_failure') . $this->user_model->error, 'error');
            }
		}
        $data['record'] = array();


        foreach( $data as $key => $value )
            Template::set($key, $value);

		Template::render();
	}
	/**
	 * Allows editing of user data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(4);
		if (empty($id)) {
			Template::set_message(lang('usermaint_invalid_id'), 'error');

			redirect('/admin/users');
		}

		$data = array('page_title'=>lang('usermaint_area_title'),
         'page_subtitle'=>lang('usermaint_edit_heading'),
         'page_breadcrumb'=>lang('usermaint_manage'));

        
		if (isset($_POST['save'])) {
			$this->auth->restrict($this->permissionEdit);

			if ($this->save_usermaint('update', $id)) {
				log_activity($this->auth->user_id(), lang('usermaint_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'usermaint');
				Template::set_message(lang('usermaint_edit_success'), 'success');
				redirect('/admin/users/');
			}

            // Not validation error
            if ( ! empty($this->user_model->error)) {
                Template::set_message(lang('usermaint_edit_failure') . $this->user_model->error, 'error');
			}
		}
        
		elseif (isset($_POST['delete'])) {
			$this->auth->restrict($this->permissionDelete);

			if ($this->user_model->delete($id)) {
				log_activity($this->auth->user_id(), lang('usermaint_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'usermaint');
				Template::set_message(lang('usermaint_delete_success'), 'success');

				redirect('/admin/users');
			}

            Template::set_message(lang('usermaint_delete_failure') . $this->user_model->error, 'error');
		}
        
        Template::set('record', $this->user_model->find($id));


        foreach( $data as $key => $value )
            Template::set($key, $value);
        
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Save the data.
	 *
	 * @param string $type Either 'insert' or 'update'.
	 * @param int	 $id	The ID of the record to update, ignored on inserts.
	 *
	 * @return bool|int An int ID for successful inserts, true for successful
     * updates, else false.
	 */
	private function save_usermaint($type = 'insert', $id = 0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

        // Validate the data
        $this->form_validation->set_rules($this->user_model->get_validation_rules($type));
        if ($this->form_validation->run() === false) {
            return false;
        }

		// Make sure we only pass in the fields we want
		
		$data = $this->user_model->prep_data($this->input->post());
		
		// Status checkboxes only on update
		if ($type == 'update') {
			$data['deleted']= ($this->input->post('deleted')  && $this->input->post('deleted')==1 ? 1 : 0 );
			$data['active']= ($data['deleted']==0 && $this->input->post('active')  && $this->input->post('active')==1 ? 1 : 0 );
			$data['banned']= ($this->input->post('banned') && $this->input->post('banned')==1 ? 1 : 0 );
		}

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['last_login']	= $this->input->post('last_login') ? $this->input->post('last_login') : '0000-00-00 00:00:00';
		$data['display_name_changed']	= $this->input->post('display_name_changed') ? $this->input->post('display_name_changed') : '0000-00-00';
		$data['created_on']	= $this->input->post('created_on') ? $this->input->post('created_on') : '0000-00-00 00:00:00';
		$data['modified_on']	= $this->input->post('modified_on') ? $this->input->post('modified_on') : '0000-00-00 00:00:00';
		if(isset($_POST['password'] ) && $_POST['password']!=''){
			$data['password_hash']=$this->auth->hash_password($_POST['password']);
		}
        $return = false;
		if ($type == 'insert') {
			$id = $this->user_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			}
		} elseif ($type == 'update') {
			$return = $this->user_model->update($id, $data);
		}

		return $return;
	}
}