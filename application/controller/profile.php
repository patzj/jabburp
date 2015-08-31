<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Profile extends Controller {

	function __construct() {
		parent::__construct();
	
		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
	}

	function index() {
		$data['title'] = $_SESSION['username'];
	}

	function view() {
		$username = $this->helper->url_segment(2); // get profile username from url
		if($username == null) die('Error. Do not mess with the URL.'); // stop script

		$this->model = $this->load->model('Profile_model'); // load model obj
		$result = $this->model->retrieve($username); // pass returned data to result
		unset($this->model); // early unset; will use in contact_stat

		if($result) { // check if result is not false
			$data = $result; // pass result content to data var
			$data['username'] = $username; // add username to data var; required for processing view
			$data['contact_stat'] = self::contact_stat(''); // add contact_stat to data var; required for processing view
		} else { // if false
			$data['username'] = 'unknown user'; // pass unknown user
			$data['about'] = 'This user doesn\'t exist.'; // pass doesn't exist info
		}

		$data['title'] = 'View Profile';
		$this->view = $this->load->view('Profile_view', $data); // load view obj
		unset($result); // unset result
		unset($data); // unset data
		unset($this->view); // unset view obj
	}

	function contact_stat($data) {
		if(!isset($data)) die('Direct script access not allowed.'); // just to prevent url access

		$visitor = $_SESSION['username']; // get current user
		$visited = $this->helper->url_segment(2); // get username of profile visited
		if($visited == null) die('Error. Do not mess with the URL.'); // stop script

		$data = [
			'visitor' => $visitor,
			'visited' => $visited
		]; // prepare data for db

		$this->model = $this->load->model('Contact_model'); // load contact model
		$result = $this->model->get_contact_stat($data); // pass returned data to result
		
		return $result;
	}
}