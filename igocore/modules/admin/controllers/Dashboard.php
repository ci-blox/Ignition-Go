<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 *
 * Dashboard Controller.
 *
 * Provides front-end functions for users to login and reset password.
 *
 */
class Dashboard extends Front_Controller
{
    /** @var array Site's settings to be passed to the view. */
    private $siteSettings;

    /**
     * Setup the required libraries etc.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');

//        $this->load->model('users/user_model');

        $this->load->library('securinator/Auth');

        Template::set_theme('backend');
        //$this->lang->load('users');
        $this->siteSettings = $this->settings->find_all();
  //      if ($this->siteSettings['auth.password_show_labels'] == 1) {
           //js('users', 'password_strength.js');
           //js('users', 'jquery.strength.js');
  //      }
    }

    // -------------------------------------------------------------------------
    // Authentication (Login/Logout)
    // -------------------------------------------------------------------------

    /**
     * Present the login view and allow the user to login.
     *
     * @return void
     */
    public function index()
    {
        // If the user is not already logged in, go.
        if ($this->auth->is_logged_in() === false) {
 //           Template::redirect('/admin/check/login');
        }

    Template::render();

    }


}