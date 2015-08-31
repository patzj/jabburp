<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Contact_model extends Model {

	function get_contact_stat($data) {
		extract($data); // extract passed data from controller
		$stmt = $this->conn->prepare('SELECT status FROM contact 
			WHERE user1 = (SELECT uid FROM account WHERE username = ?) 
			AND user2 = (SELECT uid FROM account WHERE username = ?)'); // prepare query for contact
		$stmt->bind_param('ss', $visitor, $visited); // bind param
		$stmt->execute(); // execute query
		$stmt->store_result(); // store result

		$result = false; // set initial return value
		if($stmt->num_rows == 1) { // check num of rows returned from query
			$stmt->bind_result($result); // bind result
			$stmt->fetch(); // fetch result
		}

		unset($data); // unset data
		$stmt->free_result(); // free stored result
		$stmt->close(); // close prepare statement
		return $result;
	}
}