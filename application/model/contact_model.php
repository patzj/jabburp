<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Contact_model extends Model {

	function get_contact_status($data) {
		extract($data); // extract passed data from controller

		$stmt = $this->conn->prepare('SELECT * FROM contact 
			WHERE (user1 = (SELECT uid FROM account WHERE username = ?) # check every possible hits 
			OR user1 = (SELECT uid FROM account WHERE username = ?)) # between current session
			AND (user2 = (SELECT uid FROM account WHERE username = ?) # and profile own
			OR user2 = (SELECT uid FROM account WHERE username = ?))'); // quite tricky query atleast for me
		$stmt->bind_param('ssss', $current, $other, $current, $other); // bind param
		$stmt->execute(); // execute query
		$result = $stmt->get_result(); // get result

		$data = false; // set initial value for return data; will remove prev value
		if($result->num_rows > 0) { // check num of rows returned from query
			while($row = $result->fetch_assoc()) { 
				$data = $row; // append row value to data array
			}
		}

		$stmt->close(); // close prepare statement
		return $data;
	}

	function cancel_contact_req($data) { // remove certain row with with pending stat
		extract($data); // extract data from controller

		$stmt = $this->conn->prepare('DELETE FROM contact 
			WHERE (user1 = (SELECT uid FROM account WHERE username = ?) # check every possible hits 
			OR user1 = (SELECT uid FROM account WHERE username = ?)) # between current session
			AND (user2 = (SELECT uid FROM account WHERE username = ?) # and profile own
			OR user2 = (SELECT uid FROM account WHERE username = ?))'); // quite tricky query atleast for me
		$stmt->bind_param('ssss', $current, $other, $current, $other); // bind param
		$result = $stmt->execute(); // execute query
		$stmt->close(); // close prepare statement

		return $result;
	}

	function confirm_contact_req($data) {
		extract($data);

		$stmt = $this->conn->prepare('UPDATE contact SET status = "confirmed" 
			WHERE (user1 = (SELECT uid FROM account WHERE username = ?) 
			AND user2 = (SELECT uid FROM account WHERE username = ?))
			AND status = "pending"');
		$stmt->bind_param('ss', $current, $other);
		if($stmt->execute()) {
			$stmt->close(); // close prev prepared statement

			$stmt = $this->conn->prepare('INSERT INTO contact 
				VALUES(?, ?, "confirmed")');
			$stmt->bind_param('ss', $other, $current);
			if($stmt->execute) {
				$stmt->close();
			}
			return true;
		} return false;
	}
}