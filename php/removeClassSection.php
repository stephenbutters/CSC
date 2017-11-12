<?php include "dbinfo.php"; ?>
<?php
	function removeClassSection($userName, $className, $secFrom, $secTo) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return "3";
		}
		$tempTable = $className.$secFrom.$secTo;
		//DELETE THE ENTRY FROM CLASS SECTION TABLE FIRST
		$query = "DELETE FROM `$tempTable` WHERE userName='$userName'";
		if(!mysqli_query($link, $query)) {
			return "3";
		}
		//DELETE THE CLASS FROM USERNAME TABLE
		$query = "DELETE FROM $userName WHERE className='$className' and secfrom='$secFrom' and secto='$secTo'";
		if(!mysqli_query($link, $query)) {
			return "3";
		}
		return "0";
		mysqli_close($link);
	}
?>

