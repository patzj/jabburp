<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Join extends Controller {

	function index() {
		$this->load->model('Join_model');
		$data = 'hello world';
		$this->load->view('Join_view', $data);
	}

}