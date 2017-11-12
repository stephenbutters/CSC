<?php include "dbinfo.php"; ?>
<?php
	include "sendEmail.php";
	include "functions.php";
	function registerUser($to, $username, $pwd, $phone) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		// check if the username is existed
		$query = "SELECT * FROM `users` WHERE `fullname`='$username' or `email`='$to'";
		if($result = mysqli_query($link, $query)) {
			echo mysqli_num_rows($result);
			if(mysqli_num_rows($result) > 0) {
				return "2"; // already exist
			}
		} else {	
			return "-1";
		}
		// create an entry in confirm table with $username and $to
		$query = "INSERT `confirm` VALUES('$username', '$to')";
		if(!mysqli_query($link, $query)) {
			return "-1";
		}
		mysqli_close($link);
		$returnvalue = shell_exec("python switchhub.py --user=$username --email=$to --password=$pwd --cellphone=$phone --action=createuser");
		if(intval($returnvalue) < 0) {
			return "-1";
		}
		$title = "Verify Your Email";
		$info = "http://ec2-13-57-38-240.us-west-1.compute.amazonaws.com/confirm.php?email=".$to."&username=".$username;
		$content = format_emailContent($username, $info, true);

		send_mail($to, $username, $title, $content);
		return $returnvalue;
		mysqli_close($link);
	}
?>
