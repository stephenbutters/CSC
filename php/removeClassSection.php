<?php require_once("dbinfo.php"); ?>
<?php
	function removeClassSection($userName, $className, $secFrom, $secTo) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');

		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return "3";
		}
		$query = "SELECT * FROM `classSectionChange` WHERE `class`='$className' AND `username`='$userName' AND `secfrom`='$secFrom' AND `secto`='$secTo' LIMIT 1";
<<<<<<< HEAD
		if(mysqli_num_rows(mysqli_query($link, $query)) <= 0) {
			return "1";
		}
=======
		// DELETE UN-EXIST CLASS OR FROM UN-EXIST USER
		if(mysqli_num_rows(mysqli_query($link, $query)) <= 0) {
   			return "1";
  		}

>>>>>>> cc148c9be199342bcf19d089b21a910628c9b2af
		$query = "DELETE FROM `classSectionChange` WHERE `username`='$userName' AND `class`='$className' AND `secfrom`='$secFrom' AND `secto`='$secTo'";
		if(!mysqli_query($link, $query)) {
			return "3"; //DB ERROR
		}
		return "0"; //SUCCESS
		mysqli_close($link);
	}
?>

