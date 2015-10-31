<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Logout_model extends Model {

	function offline($uid) {
		$status = 'offline';
		$stmt = $this->conn->prepare('UPDATE login_status
			SET status = ? WHERE uid = ?');
		$stmt->bind_param('si', $status, $uid);
		$result = $stmt->execute();
		$stmt->close();

		return $result;
	}
}