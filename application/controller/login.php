<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Login extends Controller {
	private $data;

	function __construct() {
		parent::__construct();

		session_start();
		if(isset($_SESSION['username'])) header('location: ' . BASEPATH);
		else session_destroy(); // destroy current session used for checking
	}

	function index() {
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
		if($result != null) { // check data if null
			session_start(); // start session
			$_SESSION['uid'] = $result['uid'];
			$_SESSION['username'] = $result['username']; // set session data
			header('location:' . BASEPATH); // redirect to home
		} else {
			$this->data['error_msg'] = 'Incorrect username or password.'; // add error msg
			self::index(); // return control to index
		}

	}
}