<?php include "dbinfo.php"; ?>
<?php
	$username = $_GET['username'];
	$pwd = $_GET['userpwd'];
	$pwd = md5($pwd);
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
	if(mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$query = "SELECT * FROM `users` WHERE `fullname`='$username' AND `hashed_passwd`='$pwd' LIMIT 1";
	if($result = mysqli_query($link, $query)) {
		if(mysqli_num_rows($result) <= 0) {
			echo "1";
		} else {
			$row = mysqli_fetch_assoc($result);
			if($row['active'] == 0) {
				echo "2";
			} else {
				echo "0";
			}
		}
 	}
?>