<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Users Controller
 *
 * Frontend functions for users: register, profile et al.
 *
 */
class Users extends Front_Controller
{
    private $siteSettings; 

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model('users/user_model');

        $this->load->library('securinator/Auth');

        $this->lang->load('users');
        
        $this->siteSettings = $this->settings->find_all();
 
        if ($this->siteSettings['auth.password_show_labels'] == 1) {
            Assets::add_module_js('users', 'password_strength.js');
            Assets::add_module_js('users', 'jquery.strength.js');
        }
    }

    // -------------------------------------------------------------------------
    // User Management (Register/Update Profile)
    // -------------------------------------------------------------------------

    /**
     * Allow a user to edit their own profile information.
     *
     * @return void
     */
    public function profile()
    {
        // Make sure the user is logged in.
        $this->auth->restrict();
        $this->set_current_user();

        $this->load->helper('date');

        $this->load->config('countries');
        $this->load->helper('address');

        $this->load->config('user_meta');
        $meta_fields = config_item('user_meta_fields');

        Template::set('meta_fields', $meta_fields);

        if (isset($_POST['save'])) {
            $user_id = $this->current_user->id;
            if ($this->saveUser('update', $user_id, $meta_fields)) {
                $user = $this->user_model->find($user_id);
                $log_name = empty($user->display_name) ?
                    ($this->settings_lib->item('auth.use_usernames') ? $user->username : $user->email)
                    : $user->display_name;

                // TODO log_activity
                //   lang('us_log_edit_profile')
                
                Template::set_message(lang('us_profile_updated_success'), 'success');

                // Redirect to make sure any language changes are picked up.
                Template::redirect('/users/profile');
            }

            Template::set_message(lang('us_profile_updated_error'), 'error');
        }

        // Get the current user information.
        $user = $this->user_model->find_user_and_meta($this->current_user->id);

        if ($this->siteSettings['auth.password_show_labels'] == 1) {
            Assets::add_js(
                $this->load->view('users_js', array('settings' => $this->siteSettings), true),
                'inline'
            );
        }

        // Generate password hint messages.
        $this->user_model->password_hints();

        Template::set('user', $user);
        Template::set('languages', array('' => '' ));// unserialize($this->settings_lib->item('site.languages')));

        Template::set_view('profile');
        Template::render();
    }

    /**
     * Display registration form for new user.
     *
     * @return void
     */
    public function register()
    {
        // Are users allowed to register?
        if (! $this->settings_lib->item('auth.allow_register')) {
            Template::set_message(lang('us_register_disabled'), 'error');
            Template::redirect('/');
        }

        $register_url = $this->input->post('register_url') ?: REGISTER_URL;
        $login_url    = $this->input->post('login_url') ?: LOGIN_URL;

        $this->load->model('roles/role_model');
        $this->load->helper('date');

        $this->load->config('countries');
        $this->load->helper('address');

        $this->load->config('user_meta');
        $meta_fields = config_item('user_meta_fields');
        Template::set('meta_fields', $meta_fields);
    }
}