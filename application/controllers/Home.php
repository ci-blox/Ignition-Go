<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Home controller
 *
 * The base controller which displays the homepage.
 *
 */
class Home extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('application');
		$this->load->library('Template');
		$this->lang->load('application');
		$this->load->library('events');

        // Make the requested page var available
        $this->requested_page = isset($_SESSION['requested_page']) ? $_SESSION['requested_page'] : null;
	}

	//--------------------------------------------------------------------

	/**
	 * Displays the homepage
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->library('securinator/Auth');
		$this->set_current_user();
		Template::render();
	}//end index()

	//--------------------------------------------------------------------

	/**
	 * Displays elements preview
	 *
	 * @return void
	 */
	public function elements()
	{
		$this->load->library('securinator/Auth');
		$this->set_current_user();
		Template::render();
	}//end elements()

	//--------------------------------------------------------------------

	/**
	 * Displays help
	 *
	 * @return void
	 */
	public function help()
	{
		$this->load->library('securinator/Auth');
		$this->set_current_user();
		Template::render();
	}//end help()

	//--------------------------------------------------------------------

	/**
	 * If the Auth lib is loaded, it will set the current user, since users
	 * will never be needed if the Auth library is not loaded. By not requiring
	 * this to be executed and loaded for every command, we can speed up calls
	 * that don't need users at all, or rely on a different type of auth, like
	 * an API or cronjob.
	 *
	 * Copied from Base_Controller
	 */
	protected function set_current_user()
	{
        if (class_exists('Auth')) {
			// Load our current logged in user for convenience
            if ($this->auth->is_logged_in()) {
				$this->current_user = clone $this->auth->user();

				// if the user has a language setting then use it
                if (isset($this->current_user->language)) {
					$this->config->set_item('language', $this->current_user->language);
				}
            } else {
				$this->current_user = null;
			}

			// Make the current user available in the views
            if (! class_exists('Template')) {
				$this->load->library('Template');
			}
			Template::set('current_user', $this->current_user);
		}
	}
}
/* end ./application/controllers/Home.php */
