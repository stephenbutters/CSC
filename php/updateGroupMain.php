<?php require_once("dbinfo.php");  ?>
<?php
	function updateGroupMain($username) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$index = 0;
    	$array = array();
		$query = "SELECT * FROM `groupTeams` WHERE `username`='$username'";
		if($result = mysqli_query($link, $query)) {
			while($row = mysqli_fetch_row($result)) {
    			$array[$index++] = array($row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
    		}
		}
    	return json_encode($array);
		mysqli_close($link);
	}
?>