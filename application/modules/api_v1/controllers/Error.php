<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Error controller
 *
 * Override 404 error
 *
 */

class Error extends Api_Controller {

	public function index()
	{
		$this->to_error_not_found();
	}
}