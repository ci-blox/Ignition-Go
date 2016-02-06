<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Loader
 *
 */
require_once(IGOPATH . 'libraries/MX/Router.php');
 
 
class IGO_Loader extends MX_Loader
{
    /**
     * Constructor
     * 
     * Sets the paths for the loader.
     */
    
    
    
    /**
     * [[Description]]
     */
    public function __construct()
    {
        $this->_ci_ob_level      = ob_get_level();
        $this->_ci_library_paths = array(APPPATH, IGOPATH, BASEPATH);
        $this->_ci_helper_paths  = array(APPPATH, IGOPATH, BASEPATH);
        $this->_ci_model_paths   = array(APPPATH, IGOPATH);
        $this->_ci_view_paths    = array(
            APPPATH . 'views/' => true,
            IGOPATH . 'views/'  => true
        );

        log_message('debug', 'IGO_Loader Class Initialized');

        parent::__construct();
    }

    /**
     * Internal CI Stock Library Loader
     *
     * Overridden to correct path order and load IGO_ libraries.
     *
     * @used-by CI_Loader::_ci_load_library()
     * @uses    CI_Loader::_ci_init_library()
     *
     * @param string $library     Library name to load
     * @param string $file_path   Path to the library filename, relative to libraries/
     * @param mixed  $params      Optional parameters to pass to the class constructor
     * @param string $object_name Optional object name to assign to
     *
     * @return void
     */
    protected function _ci_load_stock_library($library_name, $file_path, $params, $object_name)
    {
        $prefix = 'CI_';

        if (class_exists($prefix . $library_name, false)) {
            if (class_exists(config_item('subclass_prefix') . $library_name, false)) {
                $prefix = config_item('subclass_prefix');
            }

            // Before we deem this to be a duplicate request, let's see if a custom
            // object name is being supplied. If so, we'll return a new instance
            // of the object.
            if ($object_name !== null) {
                $CI =& get_instance();
                if (! isset($CI->$object_name)) {
                    return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
                }
            }

            log_message('debug', $library_name . ' class already loaded. Second attempt ignored.');
            return;
        }

        $paths = $this->_ci_library_paths;
        // array_pop($paths); // BASEPATH
        $searchResult = array_search(BASEPATH, $paths);
        if ($searchResult !== false) {
            unset($paths[$searchResult]);
        }
        // array_pop($paths); // APPPATH (needs to be the first path checked)
        $searchResult = array_search(APPPATH, $paths);
        if ($searchResult !== false) {
            unset($paths[$searchResult]);
        }
        array_unshift($paths, APPPATH);

        foreach ($paths as $path) {
            if (file_exists($path = "{$path}libraries/{$file_path}{$library_name}.php")) {
                // Override
                include_once($path);
                if (class_exists($prefix . $library_name, false)) {
                    return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
                } else {
                    log_message('debug', "{$path} exists, but does not declare {$prefix}{$library_name}");
                }
            }
        }

        include_once(BASEPATH . "libraries/{$file_path}{$library_name}.php");

        // Check for extensions
        $myLibraryName = config_item('subclass_prefix') . $library_name;
        foreach (array("IGO_{$library_name}", $myLibraryName) as $subclass) {
            foreach ($paths as $path) {
                if (file_exists($path = "{$path}libraries/{$file_path}{$subclass}.php")) {
                    include_once($path);
                    if (class_exists($subclass, false)) {
                        $prefix = $subclass == $myLibraryName ? config_item('subclass_prefix') : 'IGO_';
                        break;
                    } else {
                        log_message('debug', "{$path} exists, but does not declare {$subclass}");
                    }
                }
            }
        }

        return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
    }
}
