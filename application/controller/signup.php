<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Signup extends Controller {
	private $data;

	function index() {
		self::session(); // redirect to home page if logged in

		$data = @$this->data; // set local data value from instance data
		$data['title'] = 'Sign Up'; 
		$this->view = $this->load->view('Signup_view', $data);
		unset($data); // unset local data
		unset($this->data); // unset instance data
		unset($this->view); // unset view obj
	}

	private function session() {
		session_start();
		if(isset($_SESSION['username'])) header('location: ' . BASEPATH);
		else session_destroy(); // destroy current session used for checking
	}

	function validate() {
		if(empty($_POST)) die('Direct script access not allowed.');

		$array_key = key($_POST); // get current array key from POST
		switch($array_key) {
			case 'username':
				self::check_availability('username', $_POST['username']); // call function for checking db
				break;
			case 'email':
				self::check_availability('email', $_POST['email']); // call function for checking db
				break;
			default:
				echo json_encode(''); // encode empty json for ajax/post callback
				break;
		}
	}

	private function check_availability($column, $key) {
		$data = [
			'column' => $column,
			'key' => $key
		]; // prepare data for db
		$this->model = $this->load->model('Signup_model'); // load signup model
		$result = $this->model->validate($data); // pass returned data from model
		echo json_encode($result); // encode for ajax/post callback
		unset($data); // unset local data
		unset($this->model); // unset view obj
	}

	function submit() {
		self::session(); // redirect to home page if logged in

		if(empty($_POST)) die('Direct script access not allowed.');
		extract($_POST); // retrieve data
		
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
		$lastname = filter_var($lastname, FILTER_SANITIZE_STRING); // sanitize data

		$data = [
			'username' => $username,
			'password' => md5($password),
			'email' => $email,
			'firstname' => stripslashes($firstname),
			'lastname' => stripslashes($lastname), // a little bit more of sanitation
			'gender' => $gender
		]; // set data for db

		$this->model = $this->load->model('Signup_model'); // load signup model
		if($this->model->insert($data)) { // pass data to insert function; check for success/error
			self::success(); // pass control to success
		} else {
			$this->data = $_POST; // set POST content to instance data
			$this->data['error'] = 'Something went wrong. Please check input.'; // add error msg
			unset($data); // unset local data
			self::index(); // loop control to index
		}
	}

	function success() {
		self::session(); // redirect to home page if logged in

		$data['title'] = 'Sign Up';
		$this->load->view('Signup_success_view', $data);
		unset($data); // unset local data
		unset($this->view); // unset view obj
	}
}