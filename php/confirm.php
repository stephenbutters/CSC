<?php require_once("dbinfo.php"); ?>
<?php
	$email = $_GET["email"];
	$username = $_GET["username"];

	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');

	if(mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$query = "SELECT * FROM `confirm` WHERE `username`='$username' AND `email`='$email' LIMIT 1";
	if($result = mysqli_query($link, $query)) {
		if(mysqli_num_rows($result) <= 0) {
			$status = "ERROR-1";
		} else {
			$query = "UPDATE `users` SET `active`=1 WHERE `fullname`='$username' AND email='$email'";
			if(!mysqli_query($link, $query)) {
				$status = "ERROR-2";
			} else {
				$query = "DELETE FROM `confirm` WHERE `username`='$username' AND `email`='$email'";
				if(!mysqli_query($link, $query)) {
					$status = "ERROR-3";
				} else {
					$status = "SUCCESS";
				}
			}
		}
	} else {
		$status = "ERROR-4";
	}
	mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bruin Switch</title>
</head>
<body>
	<?php
		if(strcmp($status, "ERROR-1") == 0) {
			echo "<div>No Record Found!!</div>";
		} else if(strcmp($status, "ERROR-2") == 0) {
			echo "<div>MYSQL ERROR</div>";
		} else if(strcmp($status, "SUCCESS") == 0) {
			echo "<div>Success! You can log in with your username and password now.</div>";
		}
	?>
</body>
</html>