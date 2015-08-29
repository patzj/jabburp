<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Logout extends Controller {

	function __construct() {
		parent::__construct();

		session_start();
	}

	function index() {
		session_destroy();
		$data['title'] = 'Log Out';
		$this->view = $this->load->view('Logout_view');
		unset($data);
		unset($this->view);
	}
}