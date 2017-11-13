<?php require_once("dbinfo.php"); ?>
<?php
	function changePwd($username, $usernewpwd, $useremail, $userphone) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$query = "SELECT * FROM `users` WHERE `fullname`='$username' AND `email`='$useremail' AND `phone`='$userphone'";
		if($result = mysqli_query($link, $query)) {
			if(mysqli_num_rows($result) <= 0) {
				return "2";
			} else {
				$pwd = md5($usernewpwd);
				$query = "UPDATE `users` SET `hashed_passwd`='$pwd' WHERE `fullname`='$username' AND `email`='$useremail' AND `phone`='$userphone'";
				if(!mysqli_query($link, $query)) {
					return "-1";
				}
			}
		} else {
			return "-1";
		}
		return "0";
	}
?>