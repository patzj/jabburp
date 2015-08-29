<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Home extends Controller {

	function __construct() {
		parent::__construct();
	
		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
	}

	function index() {
		$this->view = $this->load->view('Home_view');
	}
}