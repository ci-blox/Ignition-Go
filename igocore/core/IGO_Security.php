<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Security Class
 *
 */
class IGO_Security extends CI_Security
{
    /**
     * @var array Controllers to ignore during the CSRF cycle. If part of a module,
     * the controller should be listed as: {module}/{controller}
     */
    protected $ignored_controllers = array();

    /**
     * The constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Get config value indicating controllers which should be ignored when
        // applying CSRF protection.
        $this->ignored_controllers = config_item('csrf_ignored_controllers');
    }

    /**
     * Show CSRF Error.
     *
     * Override the csrf_show_error method to improve the error message.
     *
     * @return void
     */
    public function csrf_show_error()
    {
        show_error(
            'The action you have requested is not allowed. You either do not have access, or your login session has expired and you need to sign in again.',
            403
        );
    }

    /**
     * Verify Cross Site Request Forgery Protection.
     *
     * Override the csrf_verify method to allow us to set controllers and modules
     * to override.
     *
     * @return object Returns $this to allow method chaining.
     */
    public function csrf_verify()
    {
        if (! empty($this->ignored_controllers)) {
            global $RTR;

            $module = $RTR->fetch_module();
            $controller = $RTR->class;

            $path = empty($module) ? $controller : "{$module}/{$controller}";

            if (in_array($path, $this->ignored_controllers)) {
                log_message('info', "CSRF verification skipped for '{$path}'");
                return $this;
            }
        }

        return parent::csrf_verify();
    }
}
