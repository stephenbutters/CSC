<?php require_once("dbinfo.php"); ?>
<?php
	function removeGroupSection($username, $groupname, $class, $section) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		//CHECK IF HE(SHE) IS THE LEADER
		$query = "SELECT * FROM `groupTeams` WHERE `leader`='$username' AND `class`='$class' AND `teamname`='$groupname' AND `section`='$section' LIMIT 1";
		if($result = mysqli_query($link, $query)) {
			if(mysqli_num_rows($result) >= 1) {
				//HE(SHE) IS THE LEADER, DELETE ALL THE ENTRIES
				$query = "DELETE FROM `groupTeams` WHERE `leader`='$username' AND `class`='$class' AND `teamname`='$groupname' AND `section`='$section'";
				if(!mysqli_query($link, $query)) {
					return "-1"; //DB ERROR
				} else {
					return "0";
				}
			}
		} else return "-1"; //DB ERROR
		//DELETE THE ENTRY FROM `groupTeam`
		$query = "DELETE FROM `groupTeams` WHERE `username`='$username' AND `class`='$class' AND `teamname`='$groupname' AND `section`='$section'";
		if(!mysqli_query($link, $query)) {
			return "-1"; //DB ERROR
		}
		//UPDATE THE TEAM INFO
		$query = "SELECT `remain` FROM `groupTeams` WHERE `teamname`='$groupname' AND `class`='$class' AND `section`='$section' LIMIT 1";
		if($result = mysqli_query($link, $query)) {
			$row = mysqli_fetch_row($result);
			$remaining = (int)$row[0]+1;
			$query = "UPDATE `groupTeams` SET `remain`=$remaining WHERE `teamname`='$groupname' AND `class`='$class' AND `section`='$section'";
			if(!mysqli_query($link, $query)) {
				return "-1"; //DB ERROR
			}
		}
		return "0";
		mysqli_close($link);
	}
?>