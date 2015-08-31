<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Contact extends Controller {

	function __construct() {
		parent::__construct();

		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
	}

	function cancel() { // this will reject/cancel request
		if(empty($_POST)) die('Direct script access not allowed.');
		
		$visitor = $_SESSION['username']; // get current user
		$visited = $_POST['data']; // get username of profile visited; h3 tag

		$data = [
			'visitor' => $visitor,
			'visited' => $visited
		]; // prepare data for db

		$this->model = $this->load->model('Contact_model'); // load contact model
		$result = $this->model->cancel_contact_req($data); // pass boolean to result
		echo json_encode($result); // encode result for ajax/post callback
	}
}