<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Home_model extends Model {

	function get_contact_list($data) {
		extract($data);

		$stmt = $this->conn->prepare("SELECT user2 FROM contact 
			WHERE user1 = ? AND status = 'confirmed'");
		$stmt->bind_param('i', $uid);
		$stmt->execute();
		$result = $stmt->get_result();

		$data = false;
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$data[] = $row['user2'];
			}
		}

		$stmt->close();
		return $data;
	}

	function get_contact_details($data) {
		$stmt = $this->conn->prepare("SELECT account.username, 
			CONCAT(user_info.firstname, ' ', user_info.lastname) AS name 
			FROM account RIGHT JOIN user_info 
			ON account.uid = user_info.uid WHERE account.uid = ?");
		$stmt->bind_param('i', $data); // uid; bind param
		$stmt->execute();
		$stmt->store_result();

		$data = false;
		if($stmt->num_rows == 1) {
			$stmt->bind_result($username, $name);
			$stmt->fetch();

			$data = [
				'username' => $username,
				'name' => $name
			];
		} 

		$stmt->free_result();
		$stmt->close();

		return $data;
	}

	function get_contact_status($data) {
		$result = [];
		foreach ($data as $uid) {
			$stmt = $this->conn->prepare('SELECT status FROM login_status 
				WHERE uid = ?');
			$stmt->bind_param('i', $uid);
			$stmt->execute();
			$stmt->store_result();

			$status = false;
			if($stmt->num_rows == 1) {
				$stmt->bind_result($status);
				$stmt->fetch();
			}
			$result[] = $status;
			$stmt->free_result();
			$stmt->close();
		}

		return $result;
	}

	function get_max_msg($data) {
		$user1 = $_SESSION['uid'];
		$result = [];
		foreach ($data as $user2) {
			$stmt = $this->conn->prepare("SELECT MAX(msg_id) FROM message
				WHERE conv_id = (SELECT conv_id FROM conversation 
				WHERE users = CONCAT(?, ', ', ?) 
				OR users = CONCAT(?, ', ', ?))");
			$stmt->bind_param('iiii', $user1, $user2, $user2, $user1);
			$stmt->execute();
			$stmt->store_result();

			$max = 0;
			if($stmt->num_rows == 1) {
				$stmt->bind_result($max);
				$stmt->fetch();
			}
			$result[] = [$user2, $max];
			$stmt->free_result();
			$stmt->close();
		}

		return $result;
	}

	function get_last_read_msg($data) {
		$user1 = $_SESSION['uid'];
		$result = [];
		foreach ($data as $user2) {
			$stmt = $this->conn->prepare('SELECT last_msg_read FROM contact
				WHERE user1 = ? AND user2 = ?');
			$stmt->bind_param('ii', $user1, $user2);
			$stmt->execute();
			$stmt->store_result();

			$lst_msg = 0;
			if($stmt->num_rows == 1) {
				$stmt->bind_result($lst_msg);
				$stmt->fetch();
			}
			$result[] = [$user2, $lst_msg];
			$stmt->free_result();
			$stmt->close();
		}

		return $result;
	}
}