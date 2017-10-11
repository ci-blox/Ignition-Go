<?php

defined('BASEPATH') || exit('No direct script access allowed');
/*
 * Array helper functions.
 *
 * Provides additional functions for working with arrays.
 *
 */

if (!function_exists('array_index_by_key')) {
    /**
     * When given an array of arrays (or objects), return the index of the
     * sub-array where $key == $value.
     *
     * <code>
     * $array = array(
     *	array('value' => 1),
     *	array('value' => 2),
     * );
     *
     * // Returns 1
     * array_index_by_key('value', 2, $array);
     * </code>
     *
     * @param mixed $key       The key to search on.
     * @param mixed $value     The value the key should be.
     * @param array $array     The array to search through.
     * @param bool  $identical Whether to perform a strict (type-checked)
     *                         comparison.
     *
     * @return false|int The index of the sub-array, or false.
     */
    function array_index_by_key($key = null, $value = null, $array = null, $identical = false)
    {
        if (empty($key) || empty($value) || !is_array($array)) {
            return false;
        }

        foreach ($array as $index => $subArray) {
            $subArray = (array) $subArray;

            if (array_key_exists($key, $subArray)) {
                if ($identical) {
                    if ($subArray[$key] === $value) {
                        return $index;
                    }
                } else {
                    if ($subArray[$key] == $value) {
                        return $index;
                    }
                }
            }
        }

        return false;
    }
}

if (!function_exists('array_multi_sort_by_column')) {
    /**
     * Sort a multi-dimensional array by a column in the sub array.
     *
     * @param array  $arr Array to sort.
     * @param string $col The name of the column to sort by.
     * @param int    $dir The sort direction SORT_ASC or SORT_DESC.
     *
     * @return void/bool Returns false on invalid input.
     */
    function array_multi_sort_by_column(&$arr, $col, $dir = SORT_ASC)
    {
        if (empty($col) || !is_array($arr)) {
            return false;
        }

        $sortCol = array();
        foreach ($arr as $key => $row) {
            $sortCol[$key] = $row[$col];
        }

        array_multisort($sortCol, $dir, $arr);
    }
}

if (!function_exists('element')) {
    /**
     * Element.
     *
     * Lets you determine whether an array index is set and whether it has a value.
     * If the element is empty it returns NULL (or whatever you specify as the default value.)
     *
     * @param	string
     * @param	array
     * @param	mixed
     *
     * @return mixed depends on what the array contains
     */
    function element($item, array $array, $default = NULL)
    {
        return array_key_exists($item, $array) ? $array[$item] : $default;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('random_element')) {
    /**
     * Random Element - Takes an array as input and returns a random element.
     *
     * @param	array
     *
     * @return mixed depends on what the array contains
     */
    function random_element($array)
    {
        return is_array($array) ? $array[array_rand($array)] : $array;
    }
}

// --------------------------------------------------------------------

if (!function_exists('elements')) {
    /**
     * Elements.
     *
     * Returns only the array items specified. Will return a default value if
     * it is not set.
     *
     * @param	array
     * @param	array
     * @param	mixed
     *
     * @return mixed depends on what the array contains
     */
    function elements($items, array $array, $default = NULL)
    {
        $return = array();

        is_array($items) OR $items = array($items);

        foreach ($items as $item) {
            $return[$item] = array_key_exists($item, $array) ? $array[$item] : $default;
        }

        return $return;
    }
}

/* End array_helper.php */
