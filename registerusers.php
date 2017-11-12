<!--  -->
<?php
	include "sendEmail.php";
	include "functions.php";
	$to = $_GET["email"];
	$username = $_GET["username"];
	$pwd = md5($_GET["pwd"]);
	$phone = $_GET['phone'];
	// check if the username is existed, if yes
	// echo "1";
	// $returnvalue = shell_exec("python switchhub.py --user=`$username` --password=`$pwd` --action='loginuser' ");
	// create an entry in confirm table with $username and $to
	$title = "Verify Your Email";
	$info = "https://yourlieinapril.000webhostapp.com/confirm.php?email=".$to."&username=".$username;
	$content = format_emailContent($info, true);

	send_mail($to, $username, $title, $content);
	echo "0";
?>
