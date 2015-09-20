<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Edit extends Controller {

	function __construct() {
		parent::__construct();

		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
		session_write_close();
	}

	function index() {
		die('Page not available.');
	}

	function profile() {
		$this->model = $this->load->model('Profile_model');
		$data = $this->model->get_user_info($_SESSION['uid']);
		unset($this->model);

		$data['title'] = 'Edit Profile';
		$this->view = $this->load->view('Edit_profile_view', $data);

		unset($data);
		unset($this->view);
	}

	function save_profile() {
		if(empty($_POST)) die('Direct script access not allowed');
		extract($_POST);

		$firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
		$lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
		$about = filter_var($about, FILTER_SANITIZE_STRING);

		$data = [
			'firstname' => stripslashes($firstname),
			'lastname' => stripslashes($lastname),
			'gender' => $gender,
			'about' => stripslashes($about)
		];

		$this->model = $this->load->model('Profile_model');
		$result = $this->model->update_user_info($data, $_SESSION['uid']);
		unset($this->model);

		if($result) {
			header('location: ' . BASEPATH . 'profile/view/' . $_SESSION['username']);
		} else {
			$data['error'] = 'Something went wrong';
			$this->view = $this->load->view('Edit_profile_view', $data);
			unset($this->view);
		}

		unset($data);
	}
}