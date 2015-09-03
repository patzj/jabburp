<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Search_model extends Model {

	function get_user_info($search_key) { 
		if(empty($search_key)) return false; // just to make sure no query will run

		$stmt = $this->conn->prepare("SELECT account.username, # username from tbl account
			CONCAT(user_info.firstname, ' ', user_info.lastname) AS name # first & last from user_info
			FROM account RIGHT JOIN user_info # get all from right table (user_info)
			ON account.uid = user_info.uid  # that can meet this condition 
			WHERE account.username = ? OR account.email = ? # condition to meet by account on 1st query
			UNION DISTINCT # will combine result set
			SELECT account.username, # username from tbl account
			CONCAT(user_info.firstname, ' ', user_info.lastname) AS name # first & last from user_info
			FROM user_info RIGHT JOIN account  # get all from left table (account)
			ON user_info.uid = account.uid # that can meet this condition
			WHERE user_info.firstname LIKE CONCAT(?, '%') # condition to meet by user_info on 2nd query
			OR user_info.lastname LIKE CONCAT(?, '%')"); // pretty sick query for my current level
		$stmt->bind_param('ssss', $search_key, $search_key, $search_key, $search_key); // bind param
		$stmt->execute(); // execute query
		$result = $stmt->get_result(); // get result

		$data = false;
		if($result->num_rows > 0) { // check num of rows returned
			while($row = $result->fetch_assoc()) { // loop until the last row returned
				$data[] = $row; // pass row array to data array; data array will contain arrays
			}
		}

		unset($search_key);
		$stmt->free_result();
		$stmt->close();
		return $data;
	}
}