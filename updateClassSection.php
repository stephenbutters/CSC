<?php include "dbinfo.php"; ?>
<?php
/*
	PERIODICALLY UPDATE CLASS SECTION
	RECEIVE VALUE: $userName
	RETURN VALUE: A TWO D ARRAY RETURN FROM MYSQL
*/
	$userName = $_GET['userName'];
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	if(mysqli_connect_errno()) {
 		printf("Connect failed: %s\n", mysqli_connect_error());
 		exit();
  	}
  	$index = 0;
  	$array = array();
  	$query = "SELECT * FROM $userName";
  	if($result = mysqli_query($link, $query)) {
  		while($row = mysqli_fetch_row($result)) {
  			$array[$index++] = array($row[0], $row[1], $row[2], $row[3]);
  		}
  	}
  	echo json_encode($array);
?>