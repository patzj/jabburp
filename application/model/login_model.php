<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Login_model extends Model {

	function verify($data) {
		extract($data); // extract passed data from controller
		unset($data); // unset data

		$stmt = $this->conn->prepare('SELECT uid, username FROM account  
			WHERE username=? AND password=?'); // prepare query for account
		$stmt->bind_param('ss', $username, $password); // bind data
		$stmt->execute(); // execute query
		$stmt->store_result(); // store result; to be fetched

		$data = false;
		if($stmt->num_rows == 1) { // check for hit
			$stmt->bind_result($uid, $username); // bind stored data to variables
			$stmt->fetch(); // fetch the stored data
			$stmt->free_result(); // free stored results
			$stmt->close(); // close

			$stmt = $this->conn->prepare("UPDATE login_status SET status = 'active' 
				WHERE uid = ?");
			$stmt->bind_param('i', $uid);

			if($stmt->execute()) {
				$data = [
					'uid' => $uid,
					'username' => $username
				]; // set return data
			}
		}

		$stmt->close(); // close prepared statement
		
		return $data; // return data; either false or assoc array
	}

	function set_login_status($data) {
		extract($data);

		$stmt = $this->conn->prepare('UPDATE login_status SET status = ? 
			WHERE uid = ?');
		$stmt->bind_param('si', $status, $uid);
		$result = $stmt->execute();
		$stmt->close();

		return $result;
	}

	function get_login_status($uid) {
		$stmt = $this->conn->prepare('SELECT status FROM login_status 
			WHERE uid = ?');
		$stmt->bind_param('i', $uid);
		$stmt->execute();
		$stmt->store_result();

		$result = false;
		if($stmt->num_rows == 1) {
			$stmt->bind_result($result);
			$stmt->fetch();
		}

		$stmt->free_result();
		$stmt->close();

		return $result;
	}

	function update_client_status($uid) {
		$stmt = $this->conn->prepare('UPDATE login_status SET last_client_ping = NOW() 
			WHERE uid = ?'); // update last ping for sql event condition
		$stmt->bind_param('i', $uid); // bind param
		$result = $stmt->execute(); // execute
		$stmt->close(); // close prepare statement

		return $result;
	}

	function update_user_activity($uid) {
		$stmt = $this->conn->prepare("UPDATE login_status SET last_user_activity = NOW(), 
			status = 'active' WHERE uid = ? AND status <> 'busy'"); // update last user act for status condition
		$stmt->bind_param('i', $uid); // bind param
		$result = $stmt->execute(); // execute
		$stmt->close(); // close prepare statement

		return $result;
	}

	function update_status_away($uid) {
		$stmt = $this->conn->prepare('SELECT last_user_activity FROM login_status 
			WHERE uid = ?'); // prepare query; last user activity time log
		$stmt->bind_param('i', $uid); // bind param
		$stmt->execute(); // execute query
		$stmt->store_result(); // store result

		if($stmt->num_rows == 1) {
			$stmt->bind_result($last_user_activity); // bind result for fetch
			$stmt->fetch();  // fetch
		}

		$stmt->free_result(); // free result
		$stmt->close(); // close prepare statment

		$time_diff = (mktime() - strtotime($last_user_activity)); // get diff bet. now and last user activity

		$result = false; // inital result value
		if($time_diff >= 299) {
			$stmt = $this->conn->prepare("UPDATE login_status SET status = 'away' 
				WHERE uid = ? AND status <> 'busy'"); // 2nd query for setting away status
			$stmt->bind_param('i', $uid); // bind param
			$result = $stmt->execute(); // execute
			$stmt->close(); // close prepared statement
		}

		return $result;
	}

	function get_contact_status($uid) {
		$stmt = $this->conn->prepare('SELECT status FROM login_status 
			WHERE uid = ?');
		$stmt->bind_param('i', $uid);
		$stmt->execute();

		$result = false;
		if($stmt->num_rows == 1) {
			$stmt->bind_result($result);
			$stmt->fetch();
		}

		$stmt->free_result();
		$stmt->close();

		return $result;
	}
}	