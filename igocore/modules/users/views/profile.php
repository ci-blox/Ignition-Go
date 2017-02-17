<?php

$errorClass   = empty($errorClass) ? ' error' : $errorClass;
$controlClass = empty($controlClass) ? 'span6' : $controlClass;
$fieldData = array(
    'errorClass'   => $errorClass,
    'controlClass' => $controlClass,
);

if (isset($password_hints)) {
    $fieldData['password_hints'] = $password_hints;
}

// In order for $renderPayload to be set properly, the order of the isset() checks
// for $current_user, $user, and $this->auth should be maintained. An if/elseif
// structure could be used for $renderPayload, but the separate if statements would
// still be needed to set $fieldData properly.
$renderPayload = null;
if (isset($current_user)) {
    $fieldData['current_user'] = $current_user;
    $renderPayload = $current_user;
}
if (isset($user)) {
    $fieldData['user'] = $user;
    $renderPayload = $user;
}
if (empty($renderPayload) && isset($this->auth)) {
    $renderPayload = $this->auth->user();
}
?>
<div class="form-group<?php echo form_error('username') ? ' error' : ''; ?>">
    <?php echo form_label(lang('us_username'), 'username', array('class' => 'control-label')); ?>
    <div class='controls'>
        <input id='username' type='text' disabled="disabled" required='required' name='username' maxlength='30' value="<?php echo set_value('username', isset($user->username) ? $user->username : ''); ?>" />
        <span class='help-inline'><?php echo form_error('username'); ?></span>
    </div>
</div>
<div class="form-group<?php echo form_error('first_name') ? ' error' : ''; ?>">
    <?php echo form_label(lang('us_first_name'), 'first_name', array('class' => 'control-label')); ?>
    <div class='controls'>
        <input id='first_name' type='text' disabled="disabled" required='required' name='first_name' maxlength='30' value="<?php echo set_value('first_name', isset($user->first_name) ? $user->first_name : ''); ?>" />
        <span class='help-inline'><?php echo form_error('first_name'); ?></span>
    </div>
</div>
<div class="form-group<?php echo form_error('last_name') ? ' error' : ''; ?>">
    <?php echo form_label(lang('us_last_name'), 'last_name', array('class' => 'control-label')); ?>
    <div class='controls'>
        <input id='last_name' type='text' disabled="disabled" required='required' name='last_name' maxlength='30' value="<?php echo set_value('last_name', isset($user->last_name) ? $user->last_name : ''); ?>" />
        <span class='help-inline'><?php echo form_error('last_name'); ?></span>
    </div>
</div>
<div class="form-group<?php echo form_error('timezone') ? ' error' : ''; ?>">
    <?php echo form_label(lang('us_timezone'), 'timezone', array('class' => 'control-label')); ?>
    <div class='controls'>
        <input id='timezone' type='text' disabled="disabled" required='required' name='timezone' maxlength='30' value="<?php echo set_value('timezone', isset($user->timezone) ? $user->timezone : ''); ?>" />
        <span class='help-inline'><?php echo form_error('timezone'); ?></span>
    </div>
</div>