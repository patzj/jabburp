<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Contact extends Controller {

	function __construct() {
		parent::__construct();

		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
		session_write_close();
	}

	function index() {
		die('Page not available');
	}

	function add() { // send contact request
		if(empty($_POST)) die('Direct script access not allowed.');

		$current = $_SESSION['username']; // get current user
		$other = $_POST['data']; // get username of other user; h3

		$data = [
			'current' => $current,
			'other' => $other
		]; // prepare data for db

		$this->model = $this->load->model('Contact_model'); // load contact model
		$result = $this->model->add_contact_req($data); // pass result from db to var
		echo json_encode($result); // encode result for ajax/post
		unset($this->model); // unset model obj
	}

	function cancel() { // this will reject/cancel request
		if(empty($_POST)) die('Direct script access not allowed.');
		
		$current = $_SESSION['username']; // get current user
		$other = $_POST['data']; // get username of other user; h3 tag

		$data = [
			'current' => $current,
			'other' => $other
		]; // prepare data for db

		$this->model = $this->load->model('Contact_model'); // load contact model
		$result = $this->model->cancel_contact_req($data); // pass boolean to result
		echo json_encode($result); // encode result for ajax/post callback
		unset($this->model); // unset model obj
	}

	function confirm() { // confirm contact request
		if(empty($_POST)) die('Direct script access not allowed.');

		$current = $_SESSION['username']; // get current user
		$other = $_POST['data']; // get other user; h3

		$data = [
			'current' => $current,
			'other' => $other
		]; // prepare data for db

		$this->model = $this->load->model('Contact_model'); // load contact model
		$result = $this->model->confirm_contact_req($data); // pass result from db to var
		echo json_encode($result); // encode result for ajax/post
		unset($this->model); // unset model obj
	}

	function requests() {
		$this->model = $this->load->model('Contact_model');
		$result = $this->model->get_requests($_SESSION['uid']);

		$data['title'] = 'Contact Requests';
		if($result) {
			$data['requests'] = $result;

		}
		$this->view = $this->load->view('Requests_view', $data);

		unset($this->model);
		unset($this->view);
	}

	function notification() {
		if(empty($_POST)) die('Direct script access not allowed.');

		$new_req_count = self::get_requests_count();

		while($new_req_count == 0) {
			$new_req_count = self::get_requests_count();
		}

		echo json_encode($new_req_count);
	}

	private function get_requests_count() {
		$this->model = $this->load->model('Contact_model');
		$result = $this->model->get_requests_count($_SESSION['uid']);
		unset($this->model);
		return $result;
	}
}