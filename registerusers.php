<?php include "dbinfo.php"; ?>
<?php
	include "sendEmail.php";
	include "functions.php";
	$to = $_GET["email"];
	$username = $_GET["username"];
	$pwd = md5($_GET["pwd"]);
	$phone = $_GET['phone'];
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
	if(mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	// check if the username is existed
	$query = "SELECT * FROM `users` WHERE `fullname`='$username' or `email`='$to'";
	if($result = mysqli_query($link, $query)) {
		echo mysqli_num_rows($result);
		if(mysqli_num_rows($result) > 0) {
			echo "2"; // already exist
			return;
		}
	} else {	
		echo "-1";
		return;
	}
	// create an entry in confirm table with $username and $to
	$query = "INSERT `confirm` VALUES('$username', '$to')";
	if(!mysqli_query($link, $query)) {
		echo "-1";
		return;
	}
	mysqli_close($link);
	$returnvalue = shell_exec("python switchhub.py --user=$username --email=$to --password=$pwd --cellphone=$phone --action=createuser");
	if(intval($returnvalue) < 0) {
		echo "-1";
		return;
	}
	$title = "Verify Your Email";
	$info = "http://ec2-13-57-38-240.us-west-1.compute.amazonaws.com/confirm.php?email=".$to."&username=".$username;
	$content = format_emailContent($username, $info, true);

	send_mail($to, $username, $title, $content);
	echo $returnvalue;
?>
