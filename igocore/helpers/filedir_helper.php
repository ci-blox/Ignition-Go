<?php

defined('BASEPATH') || exit('No direct script access allowed');
/*
 * File / Directory helper functions.
 *
*/

if (!function_exists('get_filenames_by_extension')) {
    /**
     * Get filenames by extension.
     *
     * Read the specified directory and build an array containing the filenames.
     * Any sub-folders contained within the specified path are also read.
     *
     * @param string $sourceDir   Path to the directory.
     * @param array  $extensions  Extensions of files to retrieve.
     * @param bool   $includePath Whether the path will be included with the
     *                            filename.
     * @param bool   $_recursion  Internal variable to determine recursion status.
     *                            Not intended for external use.
     *
     * @return array An array of filenames.
     */
    function get_filenames_by_extension($sourceDir, $extensions = array(), $includePath = false, $_recursion = false)
    {
        static $_filedata = array();

        if ($fp = @opendir($sourceDir)) {
            // Reset the array and ensure $sourceDir has a trailing slash on the
            // initial call
            if ($_recursion === false) {
                $_filedata = array();
                $sourceDir = rtrim(realpath($sourceDir), DIRECTORY_SEPARATOR)
                    .DIRECTORY_SEPARATOR;
            }

            while (false !== ($file = readdir($fp))) {
                if (strncmp($file, '.', 1) === 0) {
                    continue;
                }

                if (@is_dir("{$sourceDir}{$file}")) {
                    get_filenames_by_extension(
                        "{$sourceDir}{$file}".DIRECTORY_SEPARATOR,
                        $extensions,
                        $includePath,
                        true
                    );
                } elseif (in_array(pathinfo($file, PATHINFO_EXTENSION), $extensions)) {
                    $_filedata[] = $includePath ? "{$sourceDir}{$file}" : $file;
                }
            }

            return $_filedata;
        }

        return false;
    }
}

if (!function_exists('create_directory_map')) {
    /**
     * Create a Directory Map.
     *
     * Reads the specified directory and builds an array
     * representation of it. Sub-folders contained with the
     * directory will be mapped as well.
     *
     * @param string $source_dir      Path to source
     * @param int    $directory_depth Depth of directories to traverse
     *                                (0 = fully recursive, 1 = current dir, etc)
     * @param bool   $hidden          Whether to show hidden files
     *
     * @return array
     */
    function create_directory_map($source_dir, $directory_depth = 0, $hidden = false)
    {
        if ($fp = @opendir($source_dir)) {
            $filedata = array();
            $new_depth = $directory_depth - 1;
            $source_dir = rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

            while (false !== ($file = readdir($fp))) {
                // Remove '.', '..', and hidden files [optional]
                if ($file === '.'
                    || $file === '..'
                    || ($hidden === false && $file[0] === '.')
                ) {
                    continue;
                }

                if (($directory_depth < 1 || $new_depth > 0)
                    && is_dir($source_dir.$file)
                ) {
                    $filedata[$file] = create_directory_map(
                        $source_dir.$file.DIRECTORY_SEPARATOR,
                        $new_depth,
                        $hidden
                    );
                } else {
                    $filedata[] = $file;
                }
            }

            closedir($fp);

            return $filedata;
        }

        return false;
    }
}
/* End file_helper.php */
