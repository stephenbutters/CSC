<?php require_once('dbinfo.php') ?>
<?php
	function updateParking($username) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$query = "SELECT * FROM `parking` WHERE `username`='$username'";
		$array = array();
		if($result = mysqli_query($link, $query)) {
			if($row = mysqli_fetch_row($result))
				$array[0] = array($row[1], $row[2], $row[3], $row[4]);
		}
		return json_encode($array);
		mysqli_close($link);
	}
?>