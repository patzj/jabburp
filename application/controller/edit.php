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

	function validate() {
		if(empty($_POST)) die('Direct script access not allowed');

		self::check_availability('email', $_POST['email']);
	}

	private function check_availability($column, $key) {
		$data = [
			'column' => $column,
			'key' => $key
		];
		$this->model = $this->load->model('Edit_model');
		$result = $this->model->validate_email($_SESSION['uid'], $data);
		echo json_encode($result);
		unset($data);
		unset($this->model);
	}

	function profile() { // get user info from db; load edit profile view
		$this->model = $this->load->model('Profile_model');
		$data = $this->model->get_user_info($_SESSION['uid']);
		unset($this->model);

		$data['title'] = 'Edit Profile';
		$this->view = $this->load->view('Edit_profile_view', $data);

		unset($data);
		unset($this->view);
	}

	function email() { // load change email view
		$data['title'] = 'Change Email';
		$this->view = $this->load->view('Change_email_view', $data);

		unset($data);
		unset($this->view);
	}

	function password() { // load change password view
		$data['title'] = 'Change Password';
		$this->view = $this->load->view('Change_password_view', $data);

		unset($data);
		unset($this->view);
	}

	function update_profile() { // save edited user info to db
		if(empty($_POST)) die('Direct script access not allowed');
		extract($_POST);

		$firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
		$lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
		$about = filter_var($about, FILTER_SANITIZE_STRING); // sanitize input

		$data = [
			'firstname' => stripslashes($firstname),
			'lastname' => stripslashes($lastname),
			'gender' => $gender,
			'about' => stripslashes($about)
		]; // prepare data

		$this->model = $this->load->model('Profile_model');
		$result = $this->model->update_user_info($data, $_SESSION['uid']);
		unset($this->model);

		if($result) { // redirect to profile view on success
			header('location: ' . BASEPATH . 'profile/view/' . $_SESSION['username']);
		} else { // redirect to edit profile view on error
			$data['error'] = 'Something went wrong. Please check input.';
			$this->view = $this->load->view('Edit_profile_view', $data);
			unset($this->view);
		}

		unset($data);
	}

	function update_email() {
		if(empty($_POST)) die('Direct script acccess not allowed.');

		$email = filter_var(@$_POST['email'], FILTER_SANITIZE_EMAIL);

		$this->model = $this->load->model('Edit_model');
		$result = $this->model->update_email($_SESSION['uid'], $email);
		unset($this->model);

		if($result) {
			header('location: ' . BASEPATH . 'profile/view/' . $_SESSION['username']);
		} else {
			$data = [
				'title' => 'Change Email',
				'error' => 'Something went wrong. Please check input.'
			];
			$this->view = $this->load->view('Change_email_view', $data);
			unset($this->view);
		}
	}

	function update_password() {
		if(empty($_POST)) die('Direct script access not allowed.');
		extract($_POST);
		$data = [
			'uid' => $_SESSION['uid'],
			'o_password' => md5($o_password),
			'n_password' => md5($password)
		];

		$this->model = $this->load->model('Edit_model');
		$result = $this->model->update_password($data);
		unset($data);
		unset($this->model);

		if($result) {
			header('location: ' . BASEPATH . 'profile/view/' . $_SESSION['username']);
		} else {
			$data = [
				'title' => 'Change Password',
				'error' => 'Something went wrong. Please check input.'
			];
			$this->view = $this->load->view('Change_password_view', $data);
			unset($this->view);
		}
	}
}