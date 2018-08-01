<?php

if (validation_errors()):
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
if ($id==='' && !isset($record))
    $record=array();
?>
<div class='card admin-box'>
<div class='card-header'>
<h3>
   		<?php echo lang('usermaint_create'); ?>
    </h3>
    </div>
<div class='card-body'>

    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>

            <?php $this->load->view('_usermaint_fields', $record);?>

                    </div>
                        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('usermaint_action_create'); ?>" />
            <?php echo lang('app_or'); ?>
            <?php echo anchor('/admin/users', lang('usermaint_cancel'), 'class="btn btn-warning"'); ?>

        </fieldset>
    <?php echo form_close(); ?>
</div>
</div>


