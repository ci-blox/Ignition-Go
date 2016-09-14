<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Blox helper functions.
 *
*/

if ( ! function_exists('blox_modulename_check')) {
    /**
     * Form validation callback for the module name
     *
     * @param string $str String to check
     *
     * @return  bool
     */
    function blox_modulename_check($str)
    {
        $CI = &get_instance();
         
        if (! preg_match("/^([A-Za-z \-]+)$/", $str)) {
            $CI->form_validation->set_message('blox_modulename_check', lang('mb_modulename_check'));
            return false;
        }

        if (class_exists($str)) {
            $CI->form_validation->set_message('blox_modulename_check', lang('mb_modulename_check_class_exists'));
            return false;
        }

        return true;
    }

}


if (! function_exists('blox_fieldno_check')) {
    /**
     * Custom Form Validation Callback Rule
     *
     * Checks that one field doesn't match all the others.
    *
     * @param string $str    String to check against the other fields
     * @param string $sfieldinfo jsonarray [0]->fieldno The field number of this field, [1]->fieldcount The field count
     *
     * @return bool
     */
    function blox_fieldno_check($str, $sfieldinfo)
    {
        $fieldinfo = json_decode($sfieldinfo);
        $CI = &get_instance();
        for ($counter = 1; $fieldinfo[1] >= $counter; $counter++) {
            // Nothing has been entered into the current field or the current
            // field is the same as the field to validate
            if ($_POST["view_field_name$counter"] == '' || $fieldinfo[0] == $counter) {
                continue;
            }

            if ($str == $_POST["view_field_name{$counter}"]) {
                $CI->form_validation->set_message('blox_fieldno_check', sprintf(lang('mb_validation_no_match'), lang('mb_form_field_details'), lang('mb_form_fieldname'), $fieldno, $counter));
                return false;
            }
        }
        return true;
    }
    
}
/* End blox_helper.php */