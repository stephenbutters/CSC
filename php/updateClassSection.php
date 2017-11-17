<?php require_once("dbinfo.php"); ?>
<?php
/*
	PERIODICALLY UPDATE CLASS SECTION
	RECEIVE VALUE: $userName
	RETURN VALUE: A TWO D ARRAY RETURN FROM MYSQL
*/
  function updateClassSection($userName) {
  	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');

  	if(mysqli_connect_errno()) {
   		printf("Connect failed: %s\n", mysqli_connect_error());
   		exit();
    	}
    	$index = 0;
    	$array = array();
    	$query = "SELECT * FROM `classSectionChange` WHERE `username`='$userName'";
    	if($result = mysqli_query($link, $query)) {
    		while($row = mysqli_fetch_row($result)) {
    			$array[$index++] = array($row[1], $row[2], $row[3], $row[4]);
    		}
    	}
    	return json_encode($array);
      mysqli_close($link);
  }
?>