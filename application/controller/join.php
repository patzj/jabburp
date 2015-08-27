<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Join extends Controller {
	private $data;

	function index() {
		$data = @$this->data;
		$data['title'] = 'Join';
		$this->view = $this->load->view('Join_view', $data);
		unset($this->data);
		unset($this->view); // unset view obj
	}

	function signup() {
		extract($_POST); // retrieve data
		// sanitize data
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
		$lastname = filter_var($lastname, FILTER_SANITIZE_STRING);

		$data = [
			'username' => $username,
			'password' => $password,
			'email' => $email,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'gender' => $gender
		]; // set data for db

		$this->model = $this->load->model('Join_model'); // load join db model
		if($this->model->insert($data)) { // pass data to insert function; check for success/error
			//
		} else {
			//
		}
	}

	function success() {
		$this->view = $this->load->view('Join_success_view');
		unset($this->view);
	}
}