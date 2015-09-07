<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Chat extends Controller {

	private $conv_id;

	function __construct() {
		parent::__construct();

		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
	}

	function index() {
		// some codes
	}

	function display() { // display messages with other user
		if(empty($_POST)) die('Direct script access not allowed.');
		
		$current = $_SESSION['uid']; // get current user
		$other = $_POST['data']; // get other user; other user selected by current

		$this->model = $this->load->model('Helper_model'); // load helper model
		$other = $this->model->get_uid($other); // get uid of other user
		unset($this->model); // unset helper model obj

		$data = [
			'current' => $current,
			'other' => $other
		]; // prepare uid for db
		
		$this->model = $this->load->model('Chat_model'); // load chat model
		$result = $this->model->get_message($data); // pass data from db

		if($result) { // if there's some data sent back by db
			echo json_encode($result); // encode result for ajax/post
		} else echo json_encode(''); // else encode blank data

		unset($data); // unset local data
		unset($result); // unset result
		unset($this->model); // unset data model
	}

	function send() {
		extract($_POST);

		$current = $_SESSION['uid']; // get uid
		$other = $data[0]; // get other user
		$message = $data[1]; // get message to be sent
		unset($data);

		$this->model = $this->load->model('Helper_model'); // load helper model
		$other = $this->model->get_uid($other); // get uid of other user
		unset($this->model); // unset model obj; other functions will use it

		$data = [
			'current' => $current,
			'other' => $other,
		]; // prepare data for other functions

		$this->conv_id = self::get_conversation_id($data); // get conv_id of users
		while(empty($this->conv_id)) { // if no conv_id on db
			$this->conv_id = self::set_conversation_id($data); // create new conv_id for users
		}

		$message = filter_var($message, FILTER_SANITIZE_STRING); // sanitize message
		$data['message'] = stripslashes($message); // add message to data array
		$data['conv_id'] = $this->conv_id;

		echo json_encode($this->conv_id); //
		unset($this->conv_id);

	}

	private function get_conversation_id($data) { // function to get conv_id between users
		$this->model = $this->load->model('Chat_model');
		$result = $this->model->get_conversation_id($data);
		unset($this->model);

		return $result;
	}

	private function set_conversation_id($data) { // function to set conv_id for two users
		$this->model = $this->load->model('Chat_model');
		$result = $this->model->set_conversation_id($data);
		unset($this->model);

		return $result;
	}
}