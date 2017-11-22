<?php require_once('dbinfo.php') ?>
<?php
	function removeParkingSection($username) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$query = "SELECT * FROM `parking` WHERE `username`='$username'";
		if(mysqli_num_rows(mysqli_query($link, $query)) <= 0) {
			return "1"; //DOESN'T NOT HAVE THE SECTION RECORD
		}
		$query = "DELETE FROM `parking` WHERE `username`='$username'";
		mysqli_query($link, $query);
		return "0";
		mysqli_close($link);
	}
?>