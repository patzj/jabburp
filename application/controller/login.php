<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Login extends Controller {
	private $data;

	function __construct() {
		parent::__construct();

		session_start();
	}

	function index() {
		if(isset($_SESSION['username'])) header('location: ' . BASEPATH);
		else session_destroy(); // destroy current session used for checking

		$data = @$this->data; // set local data value from instance data
		$data['title'] = 'Log In';
		$this->view = $this->load->view('Login_view', $data);
		unset($data); // unset local data
		unset($this->data); // unset instance data
		unset($this->view); // unset view obj
	}

	function submit() {
		if(empty($_POST)) die('Direct script access not allowed.');
		extract($_POST);

		$username = filter_var($username, FILTER_SANITIZE_STRING); // sanitize username

		$data = [
			'username' => $username,
			'password' => md5($password)
		]; // prepare data for db

		$this->model = $this->load->model('Login_model'); // load login model
		$result = $this->model->verify($data); // pass returned data
		if($result) { // check data if null/false
			extract($result);
			session_start(); // start session
			$_SESSION['uid'] = $uid;
			$_SESSION['username'] = $username; // set session data
			session_write_close();
			header('location:' . BASEPATH); // redirect to home
		} else {
			$this->data['error_msg'] = 'Incorrect username or password.'; // add error msg
			self::index(); // return control to index
		}

	}

	function set_status() {
		$uid = $_SESSION['uid'];
		$status = $_POST['data']; // value from drop down

		$data = [
			'uid' => $uid,
			'status' => $status
		]; // data for model

		$this->model = $this->load->model('Login_model'); // load model obj
		$result = $this->model->set_login_status($data); // result from model

		echo json_encode($result); // encode result for ajax
		unset($this->model); // unset model obj
	}

	function get_status() {
		$this->model = $this->load->model('Login_model');
		$result = $this->model->get_login_status($_SESSION['uid']);

		echo json_encode($result);
		unset($this->model);
	}

	function client() { // ping from client to flag online status
		$current = $_SESSION['uid']; // current uid of user

		$this->model = $this->load->model('Login_model'); // load model
		$result = $this->model->update_client_status($current); // true or false

		echo json_encode($result);
		unset($this->model);
	}

	function activity() { // update db the last activity from user
		$current = $_SESSION['uid']; // current uid of user
		
		$this->model = $this->load->model('Login_model'); // load model
		$result = $this->model->update_user_activity($current); // true or false

		echo json_encode($result);
		unset($this->model);
	}

	function away() { // update db to away on certain conditions
		$current = $_SESSION['uid'];

		$this->model = $this->load->model('Login_model'); // load model
		$result = $this->model->update_status_away($current); // true or false

		echo json_encode($result);
		unset($this->model);
	}
}