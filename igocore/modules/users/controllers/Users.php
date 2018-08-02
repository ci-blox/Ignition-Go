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
        $this->lang->load('usermaint');

        $this->load->config('user_meta');
        $meta_fields = config_item('user_meta_fields');

        Template::set('meta_fields', $meta_fields);

        if (isset($_POST['save'])) {
            $user_id = $this->current_user->id;
            if ($this->save_user($user_id, $meta_fields)) {
                $user = $this->user_model->find($user_id);
                $log_name = empty($user->display_name) ?
                    ($this->siteSettings['auth.use_usernames'] ? $user->username : $user->email)
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

        Template::set('record', $user);
        Template::set('languages', array('' => '' ));// unserialize($this->siteSettings['site.languages')));

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
        if (!$this->siteSettings['auth.allow_register']) {
            Template::set_message(lang('us_register_disabled'), 'error');
            Template::redirect('/');
        }

        $register_url = $this->input->post('register_url') ?: REGISTER_URL;
        $login_url    = $this->input->post('login_url') ?: LOGIN_URL;

        $this->load->helper('date');

        $this->load->config('countries');
        $this->load->helper('address');

        $this->load->config('user_meta');
        $meta_fields = config_item('user_meta_fields');
        Template::set('meta_fields', $meta_fields);

        Template::set('secarea', 'users');
        Template::set('secareatitleorlogo', 'Ignition Go');
        Template::set_view('register');
        Template::render();
    }

    
    /**
     * Display forgot password form for user.
     *
     * @return void
     */
    public function forgot()
    {
        $this->load->library('settings');
        $min_length = $this->settings->item('auth.password_min_length');
        $force_numbers = $this->settings->item('auth.password_force_numbers');
        Template::set('pw_min_length', $min_length);
        Template::set('pw_force_numbers', $force_numbers);
        Template::set('secarea', '');
        Template::set('secareatitleorlogo', 'Ignition Go');
        Template::set_view('securinator/auth/forgot');
        Template::render();
    }

    /**
     * Ajax for forgot password form for user.
     *
     * @return void
     */
    public function recover()
    {
        $ret = '';
        $em = $this->input->post('em1');

        $userrec = $this->user_model->find_by('email', $em);
        $banned = $userrec == null ? '' : $userrec->banned;

        // TODO - handle cases below as desired
        $msg = '';
        $border = 'red';

        if ($banned) {
            $msg = '<p>
				<strong>Account Locked or Disabled</strong>
			</p>
			<p>
				This account has been blocked or disabled by an administrator. 
				If you feel this is an error, you may contact us  
				to make an inquiry regarding the status of the account.
			</p> ';
        } elseif (isset($confirmation)) { /* only for testing, not production */
            $border='green';
            $msg = '<p>
				Congratulations, you have created an account recovery link.
			</p>
			<p>
				<b>Please <a href=\"' . $special_link . '\">click here</a> to reset your password.</b> 
            </p> ';
        } 
        elseif (isset($emailconfirm)) {
            $border='green';
            $msg = 'Check your email for instructions on how to recover your account.';
        } 
        else //if (isset($no_match)) 
        {
            $msg = 'An account with that email address could not be found.';

            $show_form = 1;
        }

        $ret .= 'msg:"'. $msg.'", border: "'.$border.'", showform: "'.$show_form.'"';
        echo('{'.$ret.'}');
            exit;
    }

    public function reset_password(){
        $newpw=$_POST['newpw'];
        $pw_hash=$this->auth->hash_password($newpw)['hash'];
        $this->db->where('email',$_POST['email']);
        $this->db->set('password_hash',$pw_hash);
        return $this->db->update('users');
    }

//--------------------------------------------------------------------

	/**
	 * Save the user
	 *
	 * @access private
	 *
	 * @param int   $id          The id of the user in the case of an edit operation
	 * @param array $meta_fields Array of meta fields fur the user
	 *
	 * @return bool
	 */
	private function save_user($id=0, $meta_fields=array())
	{

		if ( $id == 0 )
		{
			$id = $this->current_user->id; /* ( $this->input->post('id') > 0 ) ? $this->input->post('id') :  */
		}

		$_POST['id'] = $id;

		// Simple check to make the posted id is equal to the current user's id, minor security check
		if ( $_POST['id'] != $this->current_user->id )
		{
			$this->form_validation->set_message('email', 'lang:us_invalid_userid');
			return FALSE;
		}

		// Setting the payload for Events system.
		$payload = array ( 'user_id' => $id, 'data' => $this->input->post() );

        if ($this->current_user->email != $_POST['email'])
	    	$this->form_validation->set_rules('email', 'lang:us_email', 'required|trim|valid_email|max_length[120]|unique[users.email,users.id]');
		$this->form_validation->set_rules('password', 'lang:us_password', 'max_length[120]|valid_password');

		// check if a value has been entered for the password - if so then the pass_confirm is required
		// if you don't set it as "required" the pass_confirm field could be left blank and the form validation would still pass
		$extra_rules = !empty($_POST['password']) ? 'required|' : '';
		$this->form_validation->set_rules('pass_confirm', 'lang:usermaint_password_confirm', ''.$extra_rules.'matches[password]');

		$username_required = '';
		if ($this->siteSettings['auth.login_type'] == 'username' ||
		    $this->siteSettings['auth.use_usernames'])
		{
			$username_required = 'required|';
		}
        if ($this->current_user->username != $_POST['username'])
    		$this->form_validation->set_rules('username', 'lang:usermaint_username', $username_required . 'trim|max_length[30]|unique[users.username,users.id]');

		$this->form_validation->set_rules('language', 'lang:usermaint_language', 'required|trim');
		$this->form_validation->set_rules('timezone', 'lang:usermaint_timezone', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('display_name', 'lang:usermaint_display_name', 'trim|max_length[255]');

		// Added Event "before_user_validation" to run before the form validation
		Events::trigger('before_user_validation', $payload );


        if (count($meta_fields)>0)
       //TODO
       /* foreach ($meta_fields as $field)
		{
			if ((!isset($field['admin_only']) || $field['admin_only'] === FALSE
				|| (isset($field['admin_only']) && $field['admin_only'] === TRUE
					&& isset($this->current_user) && $this->current_user->role_id == 1))
				&& (!isset($field['frontend']) || $field['frontend'] === TRUE))
			{
				$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
			}
		}
*/

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// Compile our core user elements to save.
		$data = array(
			'email'		=> $this->input->post('email'),
			'language'	=> $this->input->post('language'),
			'timezone'	=> $this->input->post('timezone'),
		);

		// If empty, the password will be left unchanged.
		if ($this->input->post('password') !== '')
		{
			$data['password'] = $this->input->post('password');
		}

		if ($this->input->post('display_name') !== '')
		{
			$data['display_name'] = $this->input->post('display_name');
		}

		if (isset($_POST['username']))
		{
			$data['username'] = $this->input->post('username');
		}

		// Any modules needing to save data?
		// Event to run after saving a user
		Events::trigger('save_user', $payload );

		return $this->user_model->update($id, $data);

	}//end save_user()

	

}
