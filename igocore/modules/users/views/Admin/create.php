<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-danger fade in'>
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
<div class='col-sm-offset-1 admin-box'>
    <h3>
    	<?php echo lang('usermaint_area_title'); ?>
    </h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                     'admin' =>  'admin ',
                     'staff' =>  'staff ',
                     'user' =>  'user ',
                     'support' =>  'support ',
                );
                echo form_dropdown(array('name' => 'role'), $options, set_value('role', isset($usermaint->role) ? $usermaint->role : ''), lang('usermaint_field_role'));
            ?>

            <div class="form-group<?php echo form_error('email') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_email') . lang('app_form_label_required'), 'email', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='email' type='text' required='required' name='email' maxlength='254' value="<?php echo set_value('email', isset($usermaint->email) ? $usermaint->email : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('email'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('username') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_username') . lang('app_form_label_required'), 'username', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='username' type='text' required='required' name='username' maxlength='30' value="<?php echo set_value('username', isset($usermaint->username) ? $usermaint->username : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('username'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('first_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_first_name') . lang('app_form_label_required'), 'first_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='first_name' type='text' required='required' name='first_name' maxlength='50' value="<?php echo set_value('first_name', isset($usermaint->first_name) ? $usermaint->first_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('first_name'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('last_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_last_name') . lang('app_form_label_required'), 'last_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='last_name' type='text' required='required' name='last_name' maxlength='50' value="<?php echo set_value('last_name', isset($usermaint->last_name) ? $usermaint->last_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('last_name'); ?></span>
                </div>
            </div>

            <!--<div class="form-group<?//php echo form_error('password_hash') ? ' error' : ''; ?>">
                <?//php echo form_label(lang('usermaint_field_password_hash'), 'password_hash', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='password_hash' type='text' name='password_hash' maxlength='255' value="<?//php echo set_value('password_hash', isset($usermaint->password_hash) ? $usermaint->password_hash : ''); ?>" />
                    <span class='help-inline'><?//php echo form_error('password_hash'); ?></span>
                </div>
            </div>-->

            <!--<div class="form-group<?//php echo form_error('reset_hash') ? ' error' : ''; ?>">
                <?//php echo form_label(lang('usermaint_field_reset_hash'), 'reset_hash', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='reset_hash' type='text' name='reset_hash' maxlength='40' value="<?//php echo set_value('reset_hash', isset($usermaint->reset_hash) ? $usermaint->reset_hash : ''); ?>" />
                    <span class='help-inline'><?//php echo form_error('reset_hash'); ?></span>
                </div>
            </div>-->
            <div class="form-group<?php echo form_error('password') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_password'), 'password', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='password' type='text' name='password' maxlength='255' value="" />
                    <span class='help-inline'><?php echo form_error('password'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('pass_confirm') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_password_confirm'), 'reset_hash', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='pass_confirm' type='text' name='pass_confirm' maxlength='255' value="<?php //echo set_value('pass_confirm', isset($usermaint->pass_confirm) ? $usermaint->pass_confirm : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('pass_confirm'); ?></span>
                </div>
            </div>
            <div class="form-group<?php echo form_error('last_login') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_last_login'), 'last_login', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='last_login' type='text' name='last_login' maxlength='33' value="<?php echo set_value('last_login', isset($usermaint->last_login) ? $usermaint->last_login : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('last_login'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('last_ip') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_last_ip'), 'last_ip', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='last_ip' type='text' name='last_ip' maxlength='45' value="<?php echo set_value('last_ip', isset($usermaint->last_ip) ? $usermaint->last_ip : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('last_ip'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('force_password_reset') ? ' error' : ''; ?>">
                <div class='controls'>
                    <label class='checkbox' for='force_password_reset'>
                        <input type='checkbox' id='force_password_reset' name='force_password_reset'  value='1' <?php echo set_checkbox('force_password_reset', 1, isset($usermaint->force_password_reset) && $usermaint->force_password_reset == 1); ?> />
                        <?php echo lang('usermaint_field_force_password_reset'); ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('force_password_reset'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('reset_by') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_reset_by'), 'reset_by', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='reset_by' type='text' name='reset_by' maxlength='10' value="<?php echo set_value('reset_by', isset($usermaint->reset_by) ? $usermaint->reset_by : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('reset_by'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('banned') ? ' error' : ''; ?>">
                <div class='controls'>
                    <label class='checkbox' for='banned'>
                        <input type='checkbox' id='banned' name='banned'  value='1' <?php echo set_checkbox('banned', 1, isset($usermaint->banned) && $usermaint->banned == 1); ?> />
                        <?php echo lang('usermaint_field_banned'); ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('banned'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('ban_message') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_ban_message'), 'ban_message', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='ban_message' type='text' name='ban_message' maxlength='255' value="<?php echo set_value('ban_message', isset($usermaint->ban_message) ? $usermaint->ban_message : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('ban_message'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('display_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_display_name'), 'display_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='display_name' type='text' name='display_name' maxlength='255' value="<?php echo set_value('display_name', isset($usermaint->display_name) ? $usermaint->display_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('display_name'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('display_name_changed') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_display_name_changed'), 'display_name_changed', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='display_name_changed' type='text' name='display_name_changed' maxlength='15' value="<?php echo set_value('display_name_changed', isset($usermaint->display_name_changed) ? $usermaint->display_name_changed : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('display_name_changed'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('timezone') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_timezone'), 'timezone', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='timezone' type='text' name='timezone' maxlength='40' value="<?php echo set_value('timezone', isset($usermaint->timezone) ? $usermaint->timezone : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('timezone'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('language') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_language'), 'language', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='language' type='text' name='language' maxlength='20' value="<?php echo set_value('language', isset($usermaint->language) ? $usermaint->language : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('language'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('active') ? ' error' : ''; ?>">
                <div class='controls'>
                    <label class='checkbox' for='active'>
                        <input type='checkbox' id='active' name='active'  value='1' <?php echo set_checkbox('active', 1, isset($usermaint->active) && $usermaint->active == 1); ?> />
                        <?php echo lang('usermaint_field_active'); ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('active'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('activate_hash') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_activate_hash'), 'activate_hash', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='activate_hash' type='text' name='activate_hash' maxlength='40' value="<?php echo set_value('activate_hash', isset($usermaint->activate_hash) ? $usermaint->activate_hash : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('activate_hash'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('created_on') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_created_on'), 'created_on', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='created_on' type='text' name='created_on' maxlength='33' value="<?php echo set_value('created_on', isset($usermaint->created_on) ? $usermaint->created_on : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('created_on'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('modified_on') ? ' error' : ''; ?>">
                <?php echo form_label(lang('usermaint_field_modified_on'), 'modified_on', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='modified_on' type='text' name='modified_on' maxlength='33' value="<?php echo set_value('modified_on', isset($usermaint->modified_on) ? $usermaint->modified_on : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('modified_on'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('deleted') ? ' error' : ''; ?>">
                <div class='controls'>
                    <label class='checkbox' for='deleted'>
                        <input type='checkbox' id='deleted' name='deleted'  value='1' <?php echo set_checkbox('deleted', 1, isset($usermaint->deleted) && $usermaint->deleted == 1); ?> />
                        <?php echo lang('usermaint_field_deleted'); ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('deleted'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('usermaint_action_create'); ?>" />
            <?php echo lang('app_or'); ?>
            <?php echo anchor(SITE_AREA . '/admin/usermaint', lang('usermaint_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>