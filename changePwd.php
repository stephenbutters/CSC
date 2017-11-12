<?php include "dbinfo.php"; ?>
<?php
	$username = $_GET["username"];
	$usernewpwd = $_GET["userpwd"];
	$useremail = $_GET["useremail"];
	$userphone = $_GET["userphone"];
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
	if(mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$query = "SELECT * FROM `users` WHERE `fullname`='$username' AND `email`='$useremail' AND `phone`='$userphone'";
	if($result = mysqli_query($link, $query)) {
		if(mysqli_num_rows($result) <= 0) {
			echo "2";
		} else {
			$pwd = md5($usernewpwd);
			$query = "UPDATE `users` SET `hashed_passwd`='$pwd' WHERE `fullname`='$username' AND `email`='$useremail' AND `phone`='$userphone'";
			if(!mysqli_query($link, $query)) {
				echo "-1";
			}
		}
	} else {
		echo "-1";
	}
	echo "0";
?>