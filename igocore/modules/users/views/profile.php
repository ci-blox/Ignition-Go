<?php

$errorClass   = empty($errorClass) ? ' error' : $errorClass;
$fieldData = array(
    'errorClass'   => $errorClass,
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
		<div class="col-md-offset-2 col-md-8">
		    <div class="card">
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-12">
		                    <h4>Your Profile</h4>
		                    <hr>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-md-12">
		                    <form method="post">
                                <input type="hidden" name='id' value='<?php echo $current_user->id; ?>'/>
    <div class="form-group row<?php echo form_error('username') ? ' error' : ''; ?>">
      <label for="username" class="col-4 col-form-label"><?php echo lang('usermaint_field_username');?></label> 
      <div class="col-8">
    <input type="text" maxlength='30' readonly="readonly"  id="username" name="username" placeholder="<?php echo lang('usermaint_field_username');?>" class="form-control" value="<?php echo set_value('username', isset($record->username) ? $record->username : ''); ?>"  /> 
        <span class='help-inline'><?php echo form_error('username'); ?></span>
      </div>
    </div>
    <div class="form-group row<?php echo form_error('first_name') ? ' error' : ''; ?>">
        <label for="first_name" class="col-4 col-form-label"><?php echo lang('usermaint_field_first_name') . '*';?></label> 
        <div class="col-8">
          <input type="text" maxlength='50'  id="first_name" name="first_name" placeholder="<?php echo lang('usermaint_field_first_name');?>" class="form-control"  required='required' value="<?php echo set_value('first_name', isset($record->first_name) ? $record->first_name : ''); ?>"  /> 
          <span class='help-inline'><?php echo form_error('first_name'); ?></span>
        </div>
      </div>
      <div class="form-group row<?php echo form_error('last_name') ? ' error' : ''; ?>">
    <label for="last_name" class="col-4 col-form-label"><?php echo lang('usermaint_field_last_name') . '*';?></label> 
    <div class="col-8">
      <input type="text" maxlength='50'  id="last_name" name="last_name" placeholder="<?php echo lang('usermaint_field_last_name');?>" class="form-control"  required='required' value="<?php echo set_value('last_name', isset($record->last_name) ? $record->last_name : ''); ?>"  /> 
      <span class='help-inline'><?php echo form_error('last_name'); ?></span>
    </div>
  </div>
  <div class="form-group row<?php echo form_error('email') ? ' error' : ''; ?>">
  <label for="email" class="col-4 col-form-label"><?php echo lang('usermaint_field_email') . '*';?></label> 
  <div class="col-8">
    <input type="text" maxlength='254'  id="email" name="email" placeholder="<?php echo lang('usermaint_field_email');?>" class="form-control"  required='required' value="<?php echo set_value('email', isset($record->email) ? $record->email : ''); ?>"  /> 
    <span class='help-inline'><?php echo form_error('email'); ?></span>
  </div>
</div>
    <div class="form-group row<?php echo form_error('display_name') ? ' error' : ''; ?>">
    <label for="display_name" class="col-4 col-form-label"><?php echo lang('usermaint_field_display_name');?></label> 
    <div class="col-8">
      <input type="text" maxlength='255'  id="display_name" name="display_name" placeholder="<?php echo lang('usermaint_field_display_name');?>" class="form-control" value="<?php echo set_value('display_name', isset($record->display_name) ? $record->display_name : ''); ?>"  /> 
      <input type="hidden" maxlength='10'  id="display_name_changed" name="display_name_changed" placeholder="<?php echo lang('usermaint_field_display_name_changed');?>" class="form-control" value="<?php echo set_value('display_name_changed', isset($record->display_name_changed) ? $record->display_name_changed : ''); ?>"  /> 
      <span class='help-inline'><?php echo form_error('display_name'); ?></span>
      <span class='help-inline'><?php echo form_error('display_name_changed'); ?></span>
    </div>
  </div>


  <?php
  // Modified version of the timezone list function from http://stackoverflow.com/a/17355238/507629
// Includes current time for each timezone (would help users who don't know what their timezone is)

function generate_timezone_list() 
{
    static $regions = array(
//        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
//        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
    );

    $timezones = array();
    foreach( $regions as $region )
    {
        $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
    }

    $timezone_offsets = array();
    foreach( $timezones as $timezone )
    {
        $tz = new DateTimeZone($timezone);
        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
    }

    // sort timezone by timezone name
    ksort($timezone_offsets);

    $timezone_list = array();
    foreach( $timezone_offsets as $timezone => $offset )
    {
        $offset_prefix = $offset < 0 ? '-' : '+';
        $offset_formatted = gmdate( 'H:i', abs($offset) );

        $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
        
        $t = new DateTimeZone($timezone);
        $c = new DateTime(null, $t);
        $current_time = $c->format('g:i A');

        $timezone_list[$timezone] = "(${pretty_offset}) $timezone - $current_time";
    }

    return $timezone_list;
}
  ?>
    <div class="form-group row<?php echo form_error('timezone') ? ' error' : ''; ?>">
    <label for="timezone" class="col-4 col-form-label"><?php echo lang('usermaint_field_timezone');?></label> 
    <div class="col-8">
      <?php   
                $options = generate_timezone_list();
                echo form_dropdown(array('name' => 'timezone', 'class' => 'form-control' ), $options, set_value('timezone', isset($record->timezone) ? $record->timezone : 'America/Chicago'), lang('usermaint_field_timezone'));
            ?> 
          <span class='help-inline'><?php echo form_error('timezone'); ?></span>
    </div>
  </div>
    <div class="form-group row<?php echo form_error('language') ? ' error' : ''; ?>">
    <label for="language" class="col-4 col-form-label"><?php echo lang('usermaint_field_language');?></label> 
    <div class="col-8">
    <?php   
                $options = array('english'=>'English',
                'french'=>'French',
                'italian'=>'Italian',
                'russian'=>'Russian',
                'spanish_am'=>'Spanish American'
);
                echo form_dropdown(array('name' => 'language', 'class' => 'form-control' ), $options, set_value('language', isset($record->language) ? $record->language : 'english'), lang('usermaint_field_language'));
            ?> 
      <span class='help-inline'><?php echo form_error('language'); ?></span>
    </div>
  </div>
  <div class="form-group row<?php echo form_error('password') ? ' error' : ''; ?>">
        <label for="password" class="col-4 col-form-label"><?php echo lang('usermaint_field_password');?></label> 
        <div class="col-8">
          <input type="text" maxlength='50'  id="password" name="password" placeholder="<?php echo lang('usermaint_field_password');?>" class="form-control" value="<?php echo set_value('password', isset($record->password) ? $record->password : ''); ?>"  /> 
          <span class='help-inline'><?php echo form_error('password'); ?></span>
        </div>
      </div>
      <div class="form-group row<?php echo form_error('pass_confirm') ? ' error' : ''; ?>">
        <label for="pass_confirm" class="col-4 col-form-label"><?php echo lang('usermaint_field_password_confirm');?></label> 
        <div class="col-8">
          <input type="text" maxlength='50'  id="password_confirm" name="pass_confirm" placeholder="<?php echo lang('usermaint_field_password_confirm');?>" class="form-control" value="<?php echo set_value('pass_confirm', isset($record->password_confirm) ? $record->password_confirm : ''); ?>"  /> 
          <span class='help-inline'><?php echo form_error('pass_confirm'); ?></span>
        </div>
      </div>
                                    <div class="form-group row">
                                <div class="offset-4 col-8">
                                  <button name="save" type="submit" class="btn btn-primary">Update My Profile</button>
                                </div>
                              </div>
                            </form>
		                </div>
		            </div>
		            
		        </div>
		    </div>
		</div>
<div class="col-sm-6 col-lg-4">
</div>