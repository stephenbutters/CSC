<?php 
	require_once("dbinfo.php"); 
	require_once("functions.php");
	require_once("sendEmail.php");
?>
<?php
	function joinTeams($username, $teamname, $class, $section) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		//CHECK IF THE USER HAS A TEAM NOW
		$query = "SELECT * FROM `groupTeams` WHERE (`leader`='$username' OR `username`='$username') AND `class`='$class' AND `section`='$section' LIMIT 1";
		if(mysqli_num_rows(mysqli_query($link, $query)) >= 1) {
			return "2"; //ALREADY HAVE A TEAM
		}
		//GET THE REMAINING SEAT IN THAT TEAM
		$query = "SELECT `leader`,`remain`,`descs` FROM `groupTeams` WHERE `teamname`='$teamname' AND `class`='$class' AND `section`='$section' LIMIT 1";
		if($result = mysqli_query($link, $query)) {
			if(mysqli_num_rows($result) <= 0) {
				return "-1"; //ERROR, CONCURRENCY PROBLEM>
			} else {
				$row = mysqli_fetch_row($result);
				$leader = $row[0];
				$remainning = (int)$row[1];
				$descs = $row[2];
				//IF NOW THE TEAM NEEDS ONE MORE PERSON, SO WE NEED TO DELETE ALL THE TEAM INFOS , BUT FIRST SOTRE THEM INTO ARRAY, THEN SEND EMAIL TO THEM
				if($remainning <= 1) {
					//GET LEADER'S EMAIL
					$query = "SELECT `email` FROM `users` WHERE `fullname`='$leader' LIMIT 1";
					if($result = mysqli_query($link, $query)) {
						$row = mysqli_fetch_row($result);
						$leaderEmail = $row[0];
					} else return "-1"; //
					//GET USERS EMAIL
					$query = "SELECT `email` FROM `users` WHERE `fullname`='$username' LIMIT 1";
					if($result = mysqli_query($link, $query)) {
						$row = mysqli_fetch_row($result);
						$useremail = $row[0];
					} else return "-1"; //
					//GET ALL THE ENTRIES FROM THE TEAM
					$query = "SELECT `username` FROM `groupTeams` WHERE `teamname`='$teamname' AND `class`='$class' AND `section`='$section' AND `username`!='$leader'";
					if($result = mysqli_query($link, $query)) {
						//DELETE ALL ENTRIES FROM DB
						$query = "DELETE FROM `groupTeams` WHERE `teamname`='$teamname' AND `class`='$class' AND `section`='$section'";
						if(!mysqli_query($link, $query)) return "-1"; //DB ERROR
						$emails = $useremail.' ';
						while($row = mysqli_fetch_row($result)) {
							//GET THE EMAILS
							$curuser = $row[0];
							$query1 = "INSERT `message` VALUES ('$curuser', '$class', 0, curdate())";
        					mysqli_query($link, $query1);
							$query = "SELECT `email` FROM `users` WHERE `fullname`='$curuser' LIMIT 1";
							if($result2 = mysqli_query($link, $query)) {
								$row2 = mysqli_fetch_row($result2);
								$email = $row2[0];
								$emails .= $email.' ';
								//NOW SEND A EMAIL TO NOTIFY USER WITH THE LEADER INFO
								$title = "Team Status Update";
								$content = format_emailContent($curuser, $teamname, 3, $class, $section, "bogus", $leaderEmail);
								send_mail($email, $curuser, $title, $content);
							} else return "-1"; //
						}
						//SEND TO THIS USER
						$title = "Team Status Update";
						$content = format_emailContent($username, $teamname, 3, $class, $section, "bogus", $leaderEmail);
						send_mail($useremail, $username, $title, $content);
						//SEND THE JOINED TEAM MEMBER INFO TO LEADER
						$content = format_emailContent($leader, $teamname, 4, $class, $section, "bogus", $emails);
						send_mail($leaderEmail, $leader, $title, $content);
						$query1 = "INSERT `message` VALUES ('$username', '$class', 0, curdate())";
		        		mysqli_query($link, $query1);
		        		$query1 = "INSERT `message` VALUES ('$leader', '$class', 0, curdate())";
		        		mysqli_query($link, $query1);
					} else return "-1"; //
				}
				//IF NOW THE TEAM NEEDS MORE THAN ONE PERSON, JUST ADD IT TO THE DB AND UPDATE THE DB INFO
				else {
					$remain = $remainning - 1;
					$query = "INSERT `groupTeams` VALUES('$leader', '$username', '$class', '$section', '$teamname', $remain, '$descs', curdate())";
					if(!mysqli_query($link, $query)) {
						return "-1"; //DB ERROR
					}
					//UPDATE THE REMAINING TO THE TEAM INFO
					$query = "UPDATE `groupTeams` SET `remain`=$remain WHERE `teamname`='$teamname' AND `class`='$class' AND `section`='$section'";
					if(!mysqli_query($link, $query)) {
						return "-1"; //DB ERROR
					}
				}
				return "0";
			}
		} return "-1"; //DB ERROR
	}
?>