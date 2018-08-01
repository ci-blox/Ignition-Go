<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-danger'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('usermaint_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($usermaint->id) ? $usermaint->id : '';

?>
<div class='card admin-box'>
<div class='card-header'>
<h3>
   		<?php echo lang('usermaint_edit_heading'); ?>
    </h3>
    </div>
<div class='card-body'>

    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        
            <?php $this->load->view('_usermaint_fields', $record); ?>
        
     
            

  <div class="form-group row<?php echo form_error('last_login') ? ' error' : ''; ?>">
          <label for="last_login" class="col-4 col-form-label"><?php echo lang('usermaint_field_last_login');?></label> 
          <div class="col-8">
            <input type="text" maxlength='39'  id="last_login" name="last_login" placeholder="<?php echo lang('usermaint_field_last_login');?>" class="form-control" value="<?php echo set_value('last_login', isset($record->last_login) ? $record->last_login : ''); ?>"  /> 
      <span class='help-inline'><?php echo form_error('last_login'); ?></span>
    </div>
  </div>
    <div class="form-group row<?php echo form_error('last_ip') ? ' error' : ''; ?>">
    <label for="last_ip" class="col-4 col-form-label"><?php echo lang('usermaint_field_last_ip');?></label> 
    <div class="col-8">
      <input type="text" maxlength='45'  id="last_ip" name="last_ip" placeholder="<?php echo lang('usermaint_field_last_ip');?>" class="form-control" value="<?php echo set_value('last_ip', isset($record->last_ip) ? $record->last_ip : ''); ?>"  /> 
      <span class='help-inline'><?php echo form_error('last_ip'); ?></span>
    </div>
  </div>

  <div class="form-group row<?php echo form_error('created_on') ? ' error' : ''; ?>">
    <label for="created_on" class="col-4 col-form-label"><?php echo lang('usermaint_field_created_on');?></label> 
    <div class="col-8">
      <input type="text" maxlength='39'  id="created_on" name="created_on" placeholder="<?php echo lang('usermaint_field_created_on');?>" class="form-control" value="<?php echo set_value('created_on', isset($record->created_on) ? $record->created_on : ''); ?>"  /> 
      <span class='help-inline'><?php echo form_error('created_on'); ?></span>
    </div>
  </div>
    <div class="form-group row<?php echo form_error('modified_on') ? ' error' : ''; ?>">
    <label for="modified_on" class="col-4 col-form-label"><?php echo lang('usermaint_field_modified_on');?></label> 
    <div class="col-8">
      <input type="text" maxlength='39'  id="modified_on" name="modified_on" placeholder="<?php echo lang('usermaint_field_modified_on');?>" class="form-control" value="<?php echo set_value('modified_on', isset($record->modified_on) ? $record->modified_on : ''); ?>"  /> 
      <span class='help-inline'><?php echo form_error('modified_on'); ?></span>
    </div>
  </div>

            <div class="form-group<?php echo form_error('deleted') ? ' error' : ''; ?>">
                <div class='checkbox'>
                    <label for='deleted'>
                        <input type='checkbox' id='deleted' name='deleted'  value='1' <?php echo set_checkbox('deleted', 1, isset($record->deleted) && $record->deleted == 1); ?> />
                        <?php echo lang('usermaint_field_deleted'); ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('deleted'); ?></span>
                </div>
            </div>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('usermaint_action_edit'); ?>" />
            <?php echo lang('app_or'); ?>
            <?php echo anchor('/admin/users/', lang('usermaint_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Usermaint.Admin.Delete')) : ?>
                <?php echo lang('app_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('usermaint_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('usermaint_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>