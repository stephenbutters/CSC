<?php include "dbinfo.php"; ?>
<?php
	function userValidate($username, $pwd) {
		$pwd = md5($pwd);
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return "3";
		}
		$query = "SELECT * FROM `users` WHERE `fullname`='$username' AND `hashed_passwd`='$pwd' LIMIT 1";
		if($result = mysqli_query($link, $query)) {
			if(mysqli_num_rows($result) <= 0) {
				return "1";
			} else {
				$row = mysqli_fetch_assoc($result);
				if($row['active'] == 0) {
					return "2";
				} else {
					return "0";
				}
			}
	 	} else {
	 		return "3";
	 	}
	 	mysqli_close($link);
 	}
?>