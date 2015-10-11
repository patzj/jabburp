<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Edit_model extends Model {

	function validate_email($uid, $data) {
		extract($data);

		$stmt = $this->conn->prepare("SELECT email FROM account 
			WHERE uid = ? AND $column = ?");
		$stmt->bind_param('is', $uid, $key);
		$stmt->execute();
		$stmt->store_result();

		$result = '';
		if($stmt->num_rows == 1) $result = 'email is current';

		$stmt->free_result();
		$stmt->close();

		return $result;
	}

	function update_email($uid, $email) {
		$stmt = $this->conn->prepare('UPDATE account 
			SET email = ? WHERE uid = ?');
		$stmt->bind_param('si', $email, $uid);
		$result = $stmt->execute();
		$stmt->close();

		return $result;
	}

	function update_password($data) {
		extract($data);

		$stmt = $this->conn->prepare('SELECT * FROM account 
			WHERE uid = ? AND password = ?'); // select query to verify old password
		$stmt->bind_param('is', $uid, $o_password);
		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows < 1) return false;

		$stmt->free_result();
		$stmt->close(); 

		$stmt = $this->conn->prepare('UPDATE account 
			SET password = ? WHERE uid = ?'); // update query to change password
		$stmt->bind_param('si', $n_password, $uid);
		$result = $stmt->execute();
		$stmt->close();

		return $result;
	}
}