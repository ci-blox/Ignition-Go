<?php

//------------------------------------------------------------------------------
// Setup the delete button, if this is not a create view
//------------------------------------------------------------------------------
$delete = '';
if ($action_name != 'create') {
    $delete_permission = preg_replace("/[ -]/", "_", ucfirst($module_name)) . '.' . ucfirst($controller_name) . '.Delete';
    $delete = "
    <?php if (\$this->auth->has_permission('{$delete_permission}')) : ?>
    <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick=\"return confirm('<?php e(js_escape(lang('{$module_name_lower}_delete_confirm'))); ?>');\">
    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('{$module_name_lower}_delete_record'); ?>
    </button>
    <?php endif; ?>";
}

//------------------------------------------------------------------------------
// Output the view
//------------------------------------------------------------------------------
$loadviewforfields = "";
$heading = "lang('{$module_name_lower}_{$action_name}')";
if ($action_name == 'edit') 
$heading = "lang('{$module_name_lower}_edit_heading')";

if ($action_name == 'create' || $action_name == 'edit') {
    $loadviewforfields = "<?php \$this->load->view('_{$module_name_lower}_fields', \$record); ?>";
}
echo "<?php

if (validation_errors()) :
    ?>
    <div class='alert alert-block alert-danger'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
    <?php echo lang('{$module_name_lower}_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
    </div>
    <?php
endif;

\$id = isset(\${$module_name_lower}->{$primary_key_field}) ? \${$module_name_lower}->{$primary_key_field} : '';

?>
<div class='card admin-box'>
<div class='card-header'>
<h3>
   		<?php echo $heading; ?>
    </h3>
    </div>
<div class='card-body'>

    <?php echo form_open(\$this->uri->uri_string(), 'class=\"form-horizontal\"'); ?>
        
            {$loadviewforfields}
        
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value=\"<?php echo lang('{$module_name_lower}_action_{$action_name}'); ?>\" />
            <?php echo anchor(site_url('/" . strtolower($controller_name) . "/{$module_name_lower}'), lang('{$module_name_lower}_cancel'), 'class=\"btn btn-warning\"'); ?>
            {$delete}
        </fieldset>
    <?php echo form_close(); ?></div>
</div>";
