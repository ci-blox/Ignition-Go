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
     * Present the dashboard view.
     *
     * @return void
     */
    public function index()
    {
        // If the user is not already logged in, go.
        if ($this->auth->is_logged_in() === false) {
 //           Template::redirect('/admin/check/login');
        }
        $data = array();
        // menu
        $this->load->model('menu_model');
        $this->menu_model->select('id as menu_item_id, parent_id as menu_parent_id, title as menu_item_name, concat("/admin",url) as url, menu_order, icon');
        $this->menu_model->where('menu_group','admin');
        $this->menu_model->order_by('menu_order');
        $data['menu_data'] =  $this->menu_model->as_array()->find_all(); 

        // users
        $this->load->model('users/user_model');
        $this->user_model->where('active',1);
        $data['usercount'] = $this->user_model->count_all();

        Template::set($data);
        Template::render();

    }


}