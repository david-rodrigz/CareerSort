<?php

/**
 * If user is logged in (i.e, has an 
 * active session), return the user's 
 * data. Else, return NULL.
 */
function get_logged_user($conn) {

	// check if a session is set
	if (isset($_SESSION['user_id'])) {
		$id = $_SESSION['user_id'];
		$query = "SELECT * FROM USERS WHERE user_id = '$id' LIMIT 1";

		$result = mysqli_query($conn,$query);
		if ($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	// return null if user is not logged in
	return NULL;
}