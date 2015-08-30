<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Profile extends Controller {

	function __construct() {
		parent::__construct();
	
		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
	}

	function index() {
		$data['title'] = $_SESSION['username'];
	}

	function view() {
		$username = $this->helper->url_segment(2);
		if($username == null) die('Error. Do not mess with the URL.');

		$this->model = $this->load->model('Profile_model');
		$result = $this->model->retrieve($username);
		
		if($result != null) {
			$data = $result;
			$data['username'] = $username;
		} else {
			$data['username'] = 'unknown user';
			$data['about'] = 'This user doesn\'t exist.';
		}
		$data['title'] = 'View Profile';
		$this->view = $this->load->view('Profile_view', $data);
		unset($username);
		unset($result);
		unset($data);
		unset($this->model);
		unset($this->view);
	}
}