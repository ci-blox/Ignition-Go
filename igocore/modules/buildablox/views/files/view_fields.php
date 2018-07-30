<?php

//------------------------------------------------------------------------------
// Setup the fields to be displayed in the view
//------------------------------------------------------------------------------
$field_prefix = '';
if ($db_required == 'new' && $table_as_field_prefix === true) {
    $field_prefix = "{$module_name_lower}_";
}

$viewFields = '';
for ($counter = 1; $field_total >= $counter; $counter++) {
    // Only build on fields that have data entered.
    if (set_value("view_field_label$counter") == null) {
        continue;
    }

    $maxlength = null;
    $validation_rules = $this->input->post("validation_rules{$counter}");
    $field_label = set_value("view_field_label$counter");
    $field_name  = set_value("view_field_name$counter");
    $form_name   = "{$field_prefix}{$field_name}";
    $field_type  = set_value("view_field_type$counter");

    $required = '';
    $required_attribute = false;

    // Validation rules for this fieldset
    if (is_array($validation_rules)) {
        foreach ($validation_rules as $key => $value) {
            if ($value == 'required') {
                $required = " . '*'";
                $required_attribute = true;
            }
        }
    }

   
    // general template
    $langidx = "{$module_name_lower}_field_{$field_name}";
    $inpfield = " id=\"{$form_name}\" name=\"{$form_name}\"";
    $inpfield .= ' placeholder="<?php echo lang(\''. $langidx.'\');?>" class="form-control" ';
    $inpfield .= ($required_attribute ? " required='required' " : "");
    if ($field_type!='select')
        $inpfield .= "value=\"<?php echo set_value('{$form_name}', isset(\$record->{$field_name}) ? \$record->{$field_name} : ''); ?>\" ";
    switch (substr($field_type,0,2)) {
        case 'ra':
        $inpfield = "
        <label class='radio' for='{$form_name}_option1'>
        <input id='{$form_name}_option1' name='{$form_name}' type='radio' " . ($required_attribute ? "required='required' " : "") . "value='option1' <?php echo set_radio('{$form_name}', 'option1', isset(\${$module_name_lower}->{$field_name}) && \$record->{$field_name} == 'option1'); ?> />
        Radio option 1
    </label>
    <label class='radio' for='{$form_name}_option2'>
        <input id='{$form_name}_option2' name='{$form_name}' type='radio' " . ($required_attribute ? "required='required' " : "") . "value='option2' <?php echo set_radio('{$form_name}', 'option2', isset(\${$module_name_lower}->{$field_name}) && \$record->{$field_name} == 'option2'); ?> />
        Radio option 2
    </label>
";
        break;
        case 'se':
            $inpfield = '<<sel>>';
        break;
        case 'te':
            $inpfield = '<textarea rows =\'5\' ' . $inpfield . '></textarea>';
        break;
        default:
        $inpfield = '<input type="text" ' . $inpfield . ' />';
    }
    $generic = <<<EOT
    <div class="form-group row<?php echo form_error('{$field_name}') ? ' error' : ''; ?>">
    <label for="{$form_name}" class="col-4 col-form-label"><?php echo lang('{$langidx}'){$required};?></label> 
    <div class="col-8">
      {$inpfield} 
      <span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
    </div>
  </div>
EOT;

    // Type of field
    switch ($field_type) {
        case 'textarea':
        case 'radio':
            $viewFields .= PHP_EOL . $generic;
            break;
        case 'select':
            // Use CI form helper here as it makes selects/dropdowns easier
            $select_options = array();
            if (set_value("db_field_length_value$counter") != null) {
                $select_options = explode(',', set_value("db_field_length_value$counter"));
            }
            $viewFields .= PHP_EOL . '
            <?php // Change the values in this array to populate your dropdown as required
                $options = array(';
            foreach ($select_options as $key => $option) {
                $quotedval = "'".trim(strip_slashes($option),"'")."'";
                $viewFields .= '
                    ' . $quotedval . ' => ' . $quotedval . ',';
            }
            $viewFields .= "
                ); ?>";
            $viewFields .= str_replace("<<sel>>", "
             <?php   
                echo form_dropdown(array('name' => '{$form_name}', 'class' => 'form-control' " . ($required_attribute ? ", 'required' => 'required'" : "") . "), \$options, set_value('{$form_name}', isset(\$record->{$field_name}) ? \$record->{$field_name} : ''), lang('{$module_name_lower}_field_{$field_name}'){$required});
            ?>", $generic);
            break;
        case 'checkbox':
            $viewFields .= PHP_EOL . "
            <div class=\"form-group<?php echo form_error('{$field_name}') ? ' error' : ''; ?>\">
                <div class='checkbox'>
                    <label for='{$form_name}'>
                        <input type='checkbox' id='{$form_name}' name='{$form_name}' " . ($required_attribute ? "required='required' " : "") . " value='1' <?php echo set_checkbox('{$form_name}', 1, isset(\$record->{$field_name}) && \$record->{$field_name} == 1); ?> />
                        <?php echo lang('{$module_name_lower}_field_{$field_name}'){$required}; ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
                </div>
            </div>";
            break;
        case 'input':
        case 'password':
        default:
            $type = $field_type == 'input' ? 'text' : 'password';
            $db_field_type = set_value("db_field_type$counter");
            $max = set_value("db_field_length_value$counter");
            if ($max != null) {
                if (in_array($db_field_type, $realNumberTypes)) {
                    // Constraints for real number types are expected to be in
                    // the format of 'precision,scale', but the standard allows
                    // 'precision', where a scale of 0 is implied (therefore
                    // no decimal point is used)
                    $len = explode(',', $max);
                    $max = $len[0];
                    if (! empty($len[1])) {
                        ++$max; // Add 1 to allow for the decimal point.
                    }
                }
                $maxlength = "maxlength='{$max}'";
            }

            $viewFields .= PHP_EOL . str_replace('="text"', '="'.$type.'" '.$maxlength, $generic);
            break;
    }
}

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
echo "
            {$viewFields}
";
