<?php require_once('dbinfo.php'); ?>
<?php
	function raiseTeam($leader, $teamname, $class, $section, $remain, $desc) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$query = "SELECT * FROM `groupTeams` WHERE `class`='$class' AND `section`='$section' AND (`leader`='$leader' OR `username`='$leader') LIMIT 1";
		if($result = mysqli_query($link, $query)) {
			//ALREADY HAVE A TEAM OR BE IN A TEAM, RETURN '2'
			if(mysqli_num_rows($result) >= 1) {
				return "2";
			} 
			//IF NOT OWN A TEAM OR BE IN A TEAM, ADD THE TEAM INFO TO THE DB
			else {
				$query = "INSERT `groupTeams` VALUES ('$leader', '$leader', '$class', '$section', '$teamname', $remain, '$desc', curdate())";
				if(!mysqli_query($link, $query)) {
					return "-1"; //DB ERROR
				} else {
					return "0"; //SUCCESS
				}
			}
		} else {
			return "-1"; //DB ERROR
		}
	}
	mysqli_close($link);
?>