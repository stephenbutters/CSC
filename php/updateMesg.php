<?php require_once("dbinfo.php") ?>
<?php
	function updateMesg($name) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$query = "UPDATE `message` SET `readed`=1 WHERE `username`='$name'";
		mysqli_query($link, $query);
		mysqli_close($link);	
	}
?>