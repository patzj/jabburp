<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Home extends Controller {

	function __construct() {
		parent::__construct();
	
		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
		session_write_close();
	}

	function index() { 
		$data['title'] = 'Home';
		$data['name'] = self::user()['name'];
		$data['contact_list'] = self::contact_details();
		$this->view = $this->load->view('Home_view', $data);
		unset($this->view);
	}

	function update_contact_status() {
		if(empty($_POST)) die('Direct script acccess not allowed');

		$last_contact_status = self::get_contact_status();
		$current_contact_status = self::get_contact_status();

		while($last_contact_status === $current_contact_status) { // last contact status vs current contact status
			usleep(1000000); // 1 sec
			$current_contact_status = self::get_contact_status();
		}

		echo json_encode($current_contact_status);

		return;
	}

	function contact_status() {
		if(empty($_POST)) die('Direct script acccess not allowed');

		echo json_encode(self::get_contact_status());

		return;
	}

	private function get_contact_status() {
		$data = self::contact_list();
		$this->model = $this->load->model('Home_model');
		$result = $this->model->get_contact_status($data);
		unset($this->model);
		if($result) {
			return $result;
		} 

		return false;
	}

	private function get_uid($username) {
		$this->model = $this->load->model('Helper_model');
		$uid = $this->model->get_uid($username);
		unset($this->model);

		return $uid;
	}

	private function user() { // get user info using uid
		$this->model = $this->load->model('Home_model');
		return $this->model->get_contact_details($_SESSION['uid']);
	}

	private function contact_list() { // get contact list using uid
		$data['uid'] = $_SESSION['uid'];

		$this->model = $this->load->model('Home_model');
		$result = $this->model->get_contact_list($data);

		unset($this->model);
		return $result; // could be false or array of uid's
	}

	private function contact_details() { // get details of contacts
		$data = self::contact_list();
		$this->model = $this->load->model('Home_model');
		foreach($data as $uid) {
			$result[] = $this->model->get_contact_details($uid);
		} 

		unset($this->model);
		return $result; // will return false if query fails anyway
	}
}