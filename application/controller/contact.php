<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Contact extends Controller {

	function __construct() {
		parent::__construct();

		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
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
	}
}