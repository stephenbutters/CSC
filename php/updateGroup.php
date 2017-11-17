<?php require_once("dbinfo.php"); ?>
<?php
	function updateGroup($class, $username) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$inx = 0;
		//GET ALL MY TEAMS UNDER THAT CLASS
		$leader = array();
		$query = "SELECT `leader` FROM `groupTeams` WHERE `username`='$username' AND `class`='$class'";
		if($result = mysqli_query($link, $query)) {
			while($row = mysqli_fetch_row($result)) {
				$leader[$inx++] = $row[0];
			}
		}
		$index = 0;
    	$array = array();
		$query = "SELECT * FROM `groupTeams` WHERE `class`='$class' AND `username`!='$username'";
		if($result = mysqli_query($link, $query)) {
    		while($row = mysqli_fetch_row($result)) {
    			$flag = false;
    			foreach ($leader as $i) {
    				if(strcmp($i, $row[0]) == 0) {
    					$flag = true;
    				}
    			}
    			$leader[$inx++] = $row[0];
    			if($flag) continue;
    			$array[$index++] = array($row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
    		}
    	}
    	return json_encode($array);
      	mysqli_close($link);
	}
?>