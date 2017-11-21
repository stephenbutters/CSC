<?php require_once("dbinfo.php") ?>
<?php
	function getMesg($name) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$index = 0;
		$query = "SELECT * FROM `message` WHERE `username`='$name'";
		if($result = mysqli_query($link, $query)) {
			while($row = mysqli_fetch_row($result)) {
    			$array[$index++] = array($row[1], $row[2], $row[3]);
    		}
    	}
    	return json_encode($array);	
		mysqli_close($link);	
	}
?>