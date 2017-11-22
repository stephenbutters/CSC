<?php 
	require_once("dbinfo.php"); 
	require_once "sendEmail.php";
	require_once "functions.php";
?>
<?php
	function submitParking($username, $parkingFrom, $parkingTo1, $parkingTo2) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		//CHECK IF THE USER ALREADY HAVE A SECTION, IF SO, RETURN 1
		$query = "SELECT * FROM `parking` WHERE `username`='$username' LIMIT 1";
		if(mysqli_num_rows(mysqli_query($link, $query)) >= 1) {
			return "1";
		}
		//CHECK IF THERE ARE MATCH FOR THE CURRENT SECTION
		$query = "SELECT p.username, u.email, p.parkingFrom FROM parking p, users u WHERE (p.parkingFrom='$parkingTo1' OR p.parkingFrom='$parkingTo2') AND (p.parkingTo1='$parkingFrom' OR p.parkingTo2='$parkingFrom') AND u.fullname=p.username LIMIT 1";
		if($result = mysqli_query($link, $query)) {
			if(mysqli_num_rows($result) >= 1) {
				//WE FOUND A MATCH
				$row = mysqli_fetch_row($result);
				$matchUser = $row[0];
				$matchEmail = $row[1];
				$matchFrom = $row[2];
				//DELETE THE MATCH ENTRY
				$query = "DELETE FROM `parking` WHERE `username`='$matchUser'";
				mysqli_query($link, $query);
				$title = "Status Update";
				//GET USER EMAIL
				$query = "SELECT `email` FROM `users` WHERE `fullname`='$username'";
				if($result = mysqli_query($link, $query)) {
					$row = mysqli_fetch_row($result);
					$userEmail = $row[0];
					//SEND EMAIL TO USER
					$content = format_emailContent($username, "bogus", 5, "bogus", $parkingFrom, $matchFrom, $matchEmail);
					send_mail($userEmail, $username, $title, $content);
					//SEND EMAIL TO MATCHER
					$content = format_emailContent($matchUser, "bogus", 5, "bogus", $matchFrom, $parkingFrom, $userEmail);
					send_mail($matchEmail, $matchUser, $title, $content);
					//UPDATE message DB FOR BOTH USERS
					$query1 = "INSERT `message` VALUES ('$username', 'Parking Permit Switch', 0, curdate())";
	        		mysqli_query($link, $query1);
	        		$query1 = "INSERT `message` VALUES ('$matchUser', 'Parking Permit Switch', 0, curdate())";
	        		mysqli_query($link, $query1);
	        		return "0";
				}
			}
		}
		//NO MATCH FOUND, INSERT THE SECTION INTO DB
		$query = "INSERT `parking` VALUES ('$username', '$parkingFrom', '$parkingTo1', '$parkingTo2', curdate())";
		if(mysqli_query($link, $query)) {
			return "0";
		}
		return "-1";
		mysqli_close($link);
	}
?>