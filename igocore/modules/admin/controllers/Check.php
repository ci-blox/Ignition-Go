<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 *
 * Check Auth Controller.
 *
 * Provides front-end functions for users to login and logout.
 *
 */
class Check extends Front_Controller
{
    /** @var array Site settings  */
    private $siteSettings;
    /** @var string $loginDest  */
    private $loginDest = '/admin/dashboard/index';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model('users/user_model');

        $this->load->library('securinator/Auth');

        Template::set_theme('backend');
        //$this->lang->load('users');

        $allSettings = $this->settings->find_all();

        // Filter settings
        $s = array();
        if (!empty($allSettings))
        foreach ($allSettings as $k =>$val) {
            if (substr($k,0,4)=='auth')
                $s[$k] = $val;
        }
        $this->siteSettings = $s;
        //if $this->siteSettings['auth.password_show_labels'] == 1) {
           //js('users', 'password_strength.js');
           //js('users', 'jquery.strength.js');
        //}
    }

    // -------------------------------------------------------------------------
    // Authentication (Login/Logout)
    // -------------------------------------------------------------------------

    /**
     * Present the login view and allow the user to login.
     *
     * @return void
     */
    public function login()
    {
        // If the user is already logged in, go to main destination.
        if ($this->auth->is_logged_in() !== false) {
            Template::redirect($this->loginDest);
        }

        // Try to login.
        Template::set_view('securinator/auth/login');
        if (isset($_POST['password'])
            && true === $this->auth->login(
                $this->input->post('username'),
                $this->input->post('password'),
                $this->input->post('remember_me') == '1'
            )
        ) {
          /*  TO DO: log_activity( $this->auth->user_id(),
                lang('us_log_logged_in') . ': ' . $this->input->ip_address(),
          */
            // If possible, send the user to the requested page.
            if (! empty($this->requested_page)) {
                Template::redirect($this->requested_page);
            }

            // Go to main destination.
            Template::redirect($this->loginDest);
        }

        // Pass settings.
        Template::set('settings', $this->siteSettings);

        // Prompt the user to login.
        Template::set('secarea', 'admin');
        Template::set('secareatitleorlogo', 'Admin - Ignition Go');
        Template::render('blank');
    }


    /**
     * Log out, destroy the session, and cleanup, then redirect to the home page.
     *
     * @return void
     */
    public function logout()
    {
        if (isset($this->current_user->id)) {
            // TODO Log the logout Activity.
            //lang('us_log_logged_out') . ': ' . $this->input->ip_address(),
         }

        // Always clear browser data (don't silently ignore user requests).
        $this->auth->logout();
        Template::redirect('/');
    }


}