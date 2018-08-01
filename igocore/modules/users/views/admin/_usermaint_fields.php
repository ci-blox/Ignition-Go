     

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                  'admin' =>  'admin ',
                  'staff' =>  'staff ',
                  'user' =>  'user ',
                  'support' =>  'support ',
                ); ?>    <div class="form-group row<?php echo form_error('role') ? ' error' : ''; ?>">
    <label for="role" class="col-4 col-form-label"><?php echo lang('usermaint_field_role');?></label> 
    <div class="col-8">
             <?php   
                echo form_dropdown(array('name' => 'role', 'class' => 'form-control' ), $options, set_value('role', isset($record->role) ? $record->role : 'user'), lang('usermaint_field_role'));
            ?> 
      <span class='help-inline'><?php echo form_error('role'); ?></span>
    </div>
  </div>
  <div class="form-group row<?php echo form_error('username') ? ' error' : ''; ?>">
      <label for="username" class="col-4 col-form-label"><?php echo lang('usermaint_field_username');?></label> 
      <div class="col-8">
        <input type="text" maxlength='30'  id="username" name="username" placeholder="<?php echo lang('usermaint_field_username');?>" class="form-control" value="<?php echo set_value('username', isset($record->username) ? $record->username : ''); ?>"  /> 
        <span class='help-inline'><?php echo form_error('username'); ?></span>
      </div>
    </div>
    <div class="form-group row<?php echo form_error('first_name') ? ' error' : ''; ?>">
        <label for="first_name" class="col-4 col-form-label"><?php echo lang('usermaint_field_first_name');?></label> 
        <div class="col-8">
          <input type="text" maxlength='50'  id="first_name" name="first_name" placeholder="<?php echo lang('usermaint_field_first_name');?>" class="form-control" value="<?php echo set_value('first_name', isset($record->first_name) ? $record->first_name : ''); ?>"  /> 
          <span class='help-inline'><?php echo form_error('first_name'); ?></span>
        </div>
      </div>
      <div class="form-group row<?php echo form_error('last_name') ? ' error' : ''; ?>">
    <label for="last_name" class="col-4 col-form-label"><?php echo lang('usermaint_field_last_name');?></label> 
    <div class="col-8">
      <input type="text" maxlength='50'  id="last_name" name="last_name" placeholder="<?php echo lang('usermaint_field_last_name');?>" class="form-control" value="<?php echo set_value('last_name', isset($record->last_name) ? $record->last_name : ''); ?>"  /> 
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

<input type="hidden" maxlength='255'  id="password_hash" name="password_hash" placeholder="<?php echo lang('usermaint_field_password_hash');?>" class="form-control" value="<?php echo set_value('password_hash', isset($record->password_hash) ? $record->password_hash : ''); ?>"  /> 

<input type="hidden" maxlength='40'  id="reset_hash" name="reset_hash" placeholder="<?php echo lang('usermaint_field_reset_hash');?>" class="form-control" value="<?php echo set_value('reset_hash', isset($record->reset_hash) ? $record->reset_hash : ''); ?>"  /> 

<?php if (!empty($record)) : ?>
            <div class="form-group<?php echo form_error('force_password_reset') ? ' error' : ''; ?>">
                <div class='checkbox'>
                    <label for='force_password_reset'>
                        <input type='checkbox' id='force_password_reset' name='force_password_reset'  value='1' <?php echo set_checkbox('force_password_reset', 1, isset($record->force_password_reset) && $record->force_password_reset == 1); ?> />
                        <?php echo lang('usermaint_field_force_password_reset'); ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('force_password_reset'); ?></span>
                </div>
            </div>
    
    <div class="form-group row<?php echo form_error('reset_by') ? ' error' : ''; ?>">
    <label for="reset_by" class="col-4 col-form-label"><?php echo lang('usermaint_field_reset_by');?></label> 
    <div class="col-8">
      <input type="text" maxlength='10'  id="reset_by" name="reset_by" placeholder="<?php echo lang('usermaint_field_reset_by');?>" class="form-control" value="<?php echo set_value('reset_by', isset($record->reset_by) ? $record->reset_by : ''); ?>"  /> 
      <span class='help-inline'><?php echo form_error('reset_by'); ?></span>
    </div>
  </div>

            <div class="form-group<?php echo form_error('banned') ? ' error' : ''; ?>">
                <div class='checkbox'>
                    <label for='banned'>
                        <input type='checkbox' id='banned' name='banned'  value='1' <?php echo set_checkbox('banned', 1, isset($record->banned) && $record->banned == 1); ?> />
                        <?php echo lang('usermaint_field_banned'); ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('banned'); ?></span>
                </div>
            </div>
    <div class="form-group row<?php echo form_error('ban_message') ? ' error' : ''; ?>">
    <label for="ban_message" class="col-4 col-form-label"><?php echo lang('usermaint_field_ban_message');?></label> 
    <div class="col-8">
      <input type="text" maxlength='255'  id="ban_message" name="ban_message" placeholder="<?php echo lang('usermaint_field_ban_message');?>" class="form-control" value="<?php echo set_value('ban_message', isset($record->ban_message) ? $record->ban_message : ''); ?>"  /> 
      <span class='help-inline'><?php echo form_error('ban_message'); ?></span>
    </div>
  </div>
   <?php endif; ?>
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
<?php if (!empty($record)) : ?>
    <div class="form-group<?php echo form_error('active') ? ' error' : ''; ?>">
        <div class='checkbox'>
            <label for='active'>
                <input type='checkbox' id='active' name='active'  value='1' <?php echo set_checkbox('active', 1, isset($record->active) && $record->active == 1); ?> />
                <?php echo lang('usermaint_field_active'); ?>
            </label>
            <span class='help-inline'><?php echo form_error('active'); ?></span>
        </div>
    </div>
<?php else : ?>
<input type='hidden' id='active' name='active'  value='1'>
<?php endif; ?>
<input type="hidden" id="activate_hash" name="activate_hash" placeholder="<?php echo lang('usermaint_field_activate_hash');?>" class="form-control" value="<?php echo set_value('activate_hash', isset($record->activate_hash) ? $record->activate_hash : ''); ?>"  /> 
