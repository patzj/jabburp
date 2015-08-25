<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Join extends Controller {

	function index() {
		$data['title'] = 'Join';
		$this->load->view('Join_view', $data);
	}

	function add() {
		echo 'This is add controller';
	}

}