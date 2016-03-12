<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 *
 * Check Auth Controller.
 *
 * Provides front-end functions for users to login and reset password.
 *
 */
class Check extends Front_Controller
{
    /** @var array Site's settings to be passed to the view. */
    private $siteSettings;

    /**
     * Setup the required libraries etc.
     *
     * @retun void
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model('users/user_model');

        $this->load->library('securinator/auth');

        Template::set_theme('backend');
        //$this->lang->load('users');
        $this->siteSettings = $this->settings->find_all();
        if ($this->siteSettings['auth.password_show_labels'] == 1) {
           //js('users', 'password_strength.js');
           //js('users', 'jquery.strength.js');
        }
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
        // If the user is already logged in, go home.
        if ($this->auth->is_logged_in() !== false) {
            Template::redirect('/');
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
          /**  log_activity( $this->auth->user_id(),
                lang('us_log_logged') . ': ' . $this->input->ip_address(),
                'users'
            );
*/
            // Now redirect. (If this ever changes to render something, note that
            // auth->login() currently doesn't attempt to fix `$this->current_user`
            // for the current page load).

            // If the site is configured to use role-based login destinations and
            // the login destination has been set...
            if ($this->settings_lib->item('auth.do_login_redirect')
                && ! empty($this->auth->login_destination)
            ) {
                Template::redirect($this->auth->login_destination);
            }

            // If possible, send the user to the requested page.
            if (! empty($this->requested_page)) {
                Template::redirect($this->requested_page);
            }

            // If there is nowhere else to go, go home.
            Template::redirect('/');
        }

        // Prompt the user to login.
        Template::set('secarea', 'Admin');
        Template::set('secareatitleorlogo', 'Admin - Ignition Go');
        Template::render('blank');
    }


}