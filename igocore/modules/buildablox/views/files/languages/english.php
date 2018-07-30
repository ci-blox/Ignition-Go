<?php

$fieldEntries = '';
for ($counter = 1; $field_total >= $counter; $counter++) {
    if (set_value("view_field_label$counter") == null) {
        continue; // Move onto next iteration of the loop
    }

    $field_label = set_value("view_field_label$counter");
    $field_name  = set_value("view_field_name$counter");

    $fieldEntries .= "
\$lang['{$module_name_lower}_field_{$field_name}'] = '{$field_label}';";
}

echo $lang = "<?php defined('BASEPATH') || exit('No direct script access allowed');
" . PHP_EOL . "
\$lang['{$module_name_lower}_manage']      = 'Manage {$entity_name_plural}';
\$lang['{$module_name_lower}_edit']        = 'Edit';
\$lang['{$module_name_lower}_true']        = 'True';
\$lang['{$module_name_lower}_false']       = 'False';
\$lang['{$module_name_lower}_create']      = 'Create';
\$lang['{$module_name_lower}_list']        = 'List';
\$lang['{$module_name_lower}_new']       = 'New';
\$lang['{$module_name_lower}_edit_text']     = 'Edit this to suit your needs';
\$lang['{$module_name_lower}_no_records']    = 'There are no {$entity_name_plural_lower} in the system.';
\$lang['{$module_name_lower}_create_new']    = 'Create a new {entity_name_single}.';
\$lang['{$module_name_lower}_create_success']  = '{$entity_name_single} successfully created.';
\$lang['{$entity_name_single_lower}_create_failure']  = 'There was a problem creating the {$module_name}: ';
\$lang['{$module_name_lower}_create_new_button'] = 'Create New {$entity_name_single}';
\$lang['{$module_name_lower}_invalid_id']    = 'Invalid {$entity_name_single} ID.';
\$lang['{$module_name_lower}_edit_success']    = '{$entity_name_single} successfully saved.';
\$lang['{$module_name_lower}_edit_failure']    = 'There was a problem saving the {$module_name}: ';
\$lang['{$module_name_lower}_delete_success']  = 'record(s) successfully deleted.';
\$lang['{$module_name_lower}_delete_failure']  = 'We could not delete the {$entity_name_single}: ';
\$lang['{$module_name_lower}_delete_error']    = 'You have not selected any records to delete.';
\$lang['{$module_name_lower}_actions']     = 'Actions';
\$lang['{$module_name_lower}_delete']      = 'Delete';
\$lang['{$module_name_lower}_cancel']      = 'Cancel';
\$lang['{$module_name_lower}_delete_record']   = 'Delete this {$entity_name_single}';
\$lang['{$module_name_lower}_delete_confirm']  = 'Are you sure you want to delete this {$entity_name_single}?';
\$lang['{$module_name_lower}_edit_heading']    = 'Edit {$entity_name_single}';

// Create/Edit Buttons
\$lang['{$module_name_lower}_action_edit']   = 'Save {$entity_name_single}';
\$lang['{$module_name_lower}_action_create']   = 'Create {$entity_name_single}';

// Activities
\$lang['{$module_name_lower}_act_create_record'] = 'Created record with ID';
\$lang['{$module_name_lower}_act_edit_record'] = 'Updated record with ID';
\$lang['{$module_name_lower}_act_delete_record'] = 'Deleted record with ID';

//Listing Specifics
\$lang['{$module_name_lower}_records_empty']    = 'No records found that match your selection.';
\$lang['{$module_name_lower}_errors_message']    = 'Please fix the following errors:';
\$lang['{$module_name_lower}_with_selected']    = 'with selected';

// Column Headings
\$lang['{$module_name_lower}_column_created']  = 'Created';
\$lang['{$module_name_lower}_column_deleted']  = 'Deleted';
\$lang['{$module_name_lower}_column_modified'] = 'Modified';
\$lang['{$module_name_lower}_column_deleted_by'] = 'Deleted By';
\$lang['{$module_name_lower}_column_created_by'] = 'Created By';
\$lang['{$module_name_lower}_column_modified_by'] = 'Modified By';

// Module Details
\$lang['{$module_name_lower}_module_name'] = '{$module_name}';
\$lang['{$module_name_lower}_module_description'] = '{$module_description}';
\$lang['{$module_name_lower}_area_title'] = '{$entity_name_plural}';

// Fields{$fieldEntries}";