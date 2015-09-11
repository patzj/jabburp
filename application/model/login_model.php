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

		if($stmt->num_rows == 1) { // check for hit
			$stmt->bind_result($uid, $username); // bind stored data to variables
			$stmt->fetch(); // fetch the stored data
			$stmt->free_result(); // free stored results
			$stmt->close();
			$stmt = $this->conn->prepare("UPDATE login_status SET status = 'online' 
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
		
		return $data; // return data; either null/false or assoc array
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
			status = 'online' WHERE uid = ? AND status <> 'busy'"); // update last user act for status condition
		$stmt->bind_param('i', $uid); // bind param
		$result = $stmt->execute(); // execute
		$stmt->close(); // close prepare statement

		return $result;
	}

	function update_status_idle($uid) {
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
		if($time_diff > 300) {
			$stmt = $this->conn->prepare("UPDATE login_status SET status = 'idle' 
				WHERE uid = ? AND status <> 'busy'"); // 2nd query for setting idle status
			$stmt->bind_param('i', $uid); // bind param
			$result = $stmt->execute(); // execute
			$stmt->close(); // close prepared statement
		}

		return $result;
	}
}	