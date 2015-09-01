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
			
			$contact_status = self::contact_status(); // get contact status from db
			switch($contact_status['status']) { // match results
				case 'confirmed': // if confirmed; profile btn is remove; will add message soon
					$button = ['remove', ''];
					break;
				case 'pending': // if pending
					if($_SESSION['uid'] == $contact_status['user1']) { // current user
						$button = ['pending', 'cancel']; // added the profile owner
					} else { // profile owner
						$button = ['confirm', 'reject']; // added the current user
					}
					break;
				default: // if no contact status found in db
					$button = ['add', ''];
					break;
			}
			$data['button'] = $button; // pass to data as an array
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

	private function contact_status() {
		//if(!isset($data)) die('Direct script access not allowed.'); // just to prevent url access

		$current = $_SESSION['username']; // get current user
		$other = $this->helper->url_segment(2); // get username of other user
		if($other == null) die('Error. Do not mess with the URL.'); // stop script

		$data = [
			'current' => $current,
			'other' => $other
		]; // prepare data for db

		$this->model = $this->load->model('Contact_model'); // load contact model
		$result = $this->model->get_contact_status($data); // pass returned data to result
		
		return $result;
	}
}