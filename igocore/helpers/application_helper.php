<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Application helper functions
 *
 * Includes various helper functions from across the core modules to ease editing
 * and minimize physical files which need to be loaded.
 *
 */

if (! function_exists('array_implode')) {
    /**
     * Implode an array with the key and value pair given a glue, a separator
     * between pairs, and the array to implode.
     *
     * @example $query = url_encode(array_implode('=', '&', $array)); // Encode Query Strings
     *
     * @param string $glue      The glue between key and value.
     * @param string $separator Separator between pairs.
     * @param array  $array     The array to implode.
     *
     * @return string A string with the combined elements.
     */
    function array_implode($glue, $separator, $array)
    {
        if (! is_array($array)) {
            return $array;
        }

        $string = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $val = implode(',', $val);
            }

            $string[] = "{$key}{$glue}{$val}";
        }

        return implode($separator, $string);
    }
}

if (! function_exists('dump')) {
    /**
     * Output the given variables with formatting and location.
     *
     * Huge props out to Phil Sturgeon for this one
     * (http://philsturgeon.co.uk/blog/2010/09/power-dump-php-applications).
     *
     * To use, pass in any number of variables as arguments.
     *
     * @return void
     */
    function dump()
    {
        list($callee) = debug_backtrace();
        $arguments = func_get_args();
        $totalArguments = count($arguments);

        echo "<fieldset class='dump'>" . PHP_EOL .
            "<legend>{$callee['file']} @ line: {$callee['line']}</legend>" . PHP_EOL .
            '<pre>';

        $i = 0;
        foreach ($arguments as $argument) {
            echo '<br /><strong>Debug #' . (++$i) . " of {$totalArguments}</strong>: ";

            if (! empty($argument)
                && (is_array($argument) || is_object($argument))
            ) {
                print_r($argument);
            } else {
                var_dump($argument);
            }
        }

        echo '</pre>' . PHP_EOL .
            '</fieldset>' . PHP_EOL;
    }
}

if (! function_exists('e')) {
    /**
     * A convenience function to ensure output is safe to display. Helps to defeat
     * XSS attacks by running the text through htmlspecialchars().
     *
     * Should be used anywhere user-submitted text is displayed.
     *
     * @param string $str The text to process and output.
     *
     * @return void
     */
    function e($str)
    {
        echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

if (! function_exists('js_escape')) {
    /**
     * Like html_escape() for JavaScript string literals.
     *
     * Inside attributes like onclick, you need to use html_escape() *as well*.
     *
     * Inside script tags, html_escape() would do the wrong thing, and js_escape()
     * is enough on its own.
     *
     * Useful for confirm() or alert() - but of course not document.write() or
     * similar, so take care.
     *
     * @param string $str The string to process.
     *
     * @return string The escaped string.
     */
    function js_escape($str)
    {
        /*
        $escape =
            // Obvious string literal escapes:
            '\'' . "\"" . "\\" .

            // Newlines could also break the literal;
            // escape all the C0 controls including \r\n
            "\0..\037" .

            // Escape </script> - n.b. '<' alone wouldn't work.
            // This works for HTML - XHTML would need much more here.
            "\/";
        */

        return addcslashes($str, "\"'\\\0..\037\/");
    }
}

if (! function_exists('log_activity')) {
    /**
     * Log an activity if config item 'enable_activity_logging' is true.
     *
     * @param int    $userId   The id of the user that performed the activity.
     * @param string $activity The activity details. Max length of 255 chars.
     * @param string $module   The name of the module that set the activity.
     *
     * @return int|bool The ID of the new object, or false on failure (or if
     * enable_activity_logging is not true).
     */
    function log_activity($userId = null, $activity = '', $module = 'any')
    {
        $ci =& get_instance();
        if ($ci->config->item('enable_activity_logging') === true) {
            $ci->load->model('activities/activity_model');
            return $ci->activity_model->log_activity($userId, $activity, $module);
        }

        return false;
    }
}

if (! function_exists('logit')) {
    /**
     * Log an error to the Console (if loaded) and to the log files.
     *
     * @param string $message The string to write to the logs.
     * @param string $level   The log level, as per CI log_message method.
     *
     * @return void
     */
    function logit($message = '', $level = 'debug')
    {
        if (empty($message)) {
            return;
        }

        if (class_exists('Console')) {
            Console::log($message);
        }

        log_message($level, $message);
    }
}

if (! function_exists('obj_value')) {
    /**
     *
     * @param object $obj   Object.
     * @param string $key   Name of the object element.
     * @param string $type  Input type.
     * @param int    $value Value to check the key against.
     *
     * @return null|string If $obj->$key is set, returns the value, or a
     * checked/selected string if $type is 'checkbox', 'radio', or 'select'. Returns
     * null if $obj->$key is not set.
     */
    function obj_value($obj, $key, $type = 'text', $value = 0)
    {
        if (isset($obj->$key)) {
            switch ($type) {
                case 'checkbox':
                    // no break;
                case 'radio':
                    if ($obj->$key == $value) {
                        return 'checked="checked"';
                    }
                    break;
                case 'select':
                    if ($obj->$key == $value) {
                        return 'selected="selected"';
                    }
                    break;
                case 'text':
                    // no break;
                default:
                    return $obj->$key;
            }
        }

        return null;
    }
}
