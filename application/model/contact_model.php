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

	function add_contact_req($data) { // send contact request to profile owner
		extract($data); // extract data

		$stmt = $this->conn->prepare("INSERT INTO contact(user1, user2, status)
			VALUES((SELECT uid FROM account WHERE username = ?), 
			(SELECT uid FROM account WHERE username = ?), 'pending')"); // prepare query
		$stmt->bind_param('ss', $current, $other); // bind param
		$result = $stmt->execute(); // execute query
		$stmt->close(); // close prepare statement

		return $result;
	}

	function cancel_contact_req($data) { // remove certain row/s from contact
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

	function confirm_contact_req($data) { // confirm request from profile owner
		extract($data); // extract data

		$stmt = $this->conn->prepare("UPDATE contact SET status = 'confirmed' 
			WHERE (user1 = (SELECT uid FROM account WHERE username = ?) 
			AND user2 = (SELECT uid FROM account WHERE username = ?))
			AND status = 'pending'"); // prepare 1st query; update the req to confirmed
		$stmt->bind_param('ss', $other, $current); // bind param
		if($stmt->execute()) { // execute; check if true
			$stmt->close(); // close prev prepared statement

			$stmt = $this->conn->prepare('INSERT INTO contact(user1, user2, status)
				VALUES((SELECT uid FROM account WHERE username = ?), # 2nd query
				(SELECT uid FROM account WHERE username = ?), "confirmed")'); // add another contact row for other user
			$stmt->bind_param('ss', $current, $other); // bind param
			if($stmt->execute()) { // execute; test if true
				$stmt->close(); // close prepare statement
				return true;
			}
		} return false;
	}

	function get_requests($uid) {
		$status = 'pending';
		$stmt = $this->conn->prepare('SELECT user1 FROM contact
			WHERE status = ? AND user2 = ?');
		$stmt->bind_param('si', $status, $uid);
		$stmt->execute();
		$result = $stmt->get_result(); // get result

		$data = false;
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		}

		unset($uid);
		unset($row);
		$stmt->free_result();
		$stmt->close();

		foreach ($data as $elem) {
			$stmt = $this->conn->prepare('SELECT account.username,
				user_info.firstname, user_info.lastname
				FROM account LEFT JOIN user_info
				ON account.uid = user_info.uid
				WHERE account.uid = ?');
			$stmt->bind_param('i', $elem['user1']);
			$stmt->execute();
		 	$result = $stmt->get_result();

		 	$requests = false;
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$requests[] = $row;
				}
			}

			$stmt->free_result();
			$stmt->close();
		}

		return $requests;
	}

	function get_requests_count($uid) {
		$status = 'pending';
		$stmt = $this->conn->prepare('SELECT user1 FROM contact
			WHERE status = ? AND user2 = ?');
		$stmt->bind_param('si', $status, $uid);
		$stmt->execute();
		$stmt->store_result();

		$count = $stmt->num_rows;
		$stmt->free_result();
		$stmt->close();

		return $count;
	}
}