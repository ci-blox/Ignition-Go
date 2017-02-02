<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Sample controller
 *
 * Sample REST API controller.
 *
 */

class Sample extends API_Controller {

	// [GET] /sample
	protected function get_items()
	{
		$data = array(
			array('id' => 1, 'name' => 'sample 1'),
			array('id' => 2, 'name' => 'sample 2'),
			array('id' => 3, 'name' => 'sample 3'),
		);
		$this->to_response($data);
	}

	// [GET] /sample/{id}
	protected function get_item($id)
	{
		$data = array('id' => $id, 'name' => 'sample '.$id);
		$this->to_response($data);
	}
	
	// [GET] /sample/{parent_id}/{subitem}
	protected function get_subitems($parent_id, $subitem)
	{
		$data = array(
			array('id' => 1, 'name' => 'Parent '.$parent_id.' - '.$subitem.' 1'),
			array('id' => 2, 'name' => 'Parent '.$parent_id.' - '.$subitem.' 2'),
			array('id' => 3, 'name' => 'Parent '.$parent_id.' - '.$subitem.' 3'),
		);
		$this->to_response($data);
	}

	// [POST] /sample
	protected function create_item()
	{
		$this->load->helper('array');
		$params = elements(array('filter', 'valid', 'fields', 'here'), $this->mParams);
		$this->to_created();
	}

	// [PUT] /sample/{id}
	protected function update_item($id)
	{
		$this->load->helper('array');
		$params = elements(array('filter', 'valid', 'fields', 'here'), $this->mParams);
		$this->to_accepted();
	}

	// [DELETE] /sample/{id}
	protected function remove_item($id)
	{
		$this->to_accepted();
	}
}
