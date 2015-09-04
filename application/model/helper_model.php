<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Helper_model extends model {

	function get_uid($user) {
		$stmt = $this->conn->prepare('SELECT uid FROM account 
			WHERE username = ?');
		$stmt->bind_param('s', $user);
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
}