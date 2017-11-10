<?php
//This is what I call when I click the submit button
define('DB_SERVER', 'realone.c0hpz27iuq3x.us-west-1.rds.amazonaws.com');
define('DB_USERNAME', 'hongkan');
define('DB_PASSWORD', 'aa6418463');
define('DB_DATABASE', 'realone');
  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if(mysqli_connect_errno()) {
 	printf("Connect failed: %s\n", mysqli_connect_error());
 	exit();
  }
  $userName = 'hongkan';
  $className = 'cs 130';
  $secfrom = '1A';
  $secto = '1B';
  $tempTable = $className.$secfrom.$secto;
  function checkFromTo($add) {
  	$query = "SELECT * FROM classsection WHERE className='$className' and fromSection='$secfrom' and toSection='$secto'";
  	$result = mysqli_query($link, $query);
  	$row = mysqli_fetch_row($result);
  	if($row)
	  	if($add == true) {
	  		$temp = $row[3] + 1;
	  		//UPDATE QUEUE, ADD ONE TO QUEUE
	  		$query = "UPDATE classsection set queue=$temp WHERE className='$className' and fromSection='$secfrom' and toSection='$secto'";
	  		mysqli_query($link, $query);
	  		//UPDATE CLASS TABLE, ADD USER TO THE CLASS TABLE
	  		$query = "INSERT `$tempTable` values ('$userName')";
	  		mysqli_query($link, $query);
	  	} else if($add == false) {
	  		if($row[3] == 1) {
	  			//DELETE THE ROW FROM TABLE IF IT HAS ONLY ONE USER
	  			$query = "DELETE FROM classsection WHERE className='$className' and fromSection='$secfrom' and toSection='$secto'";
	  			mysqli_query($link, $query);
	  			//GET THE TOP USER FROM QUEUE
	  			$query = "SELECT * FROM `$tempTable` LIMIT 1";
	  			$result = mysqli_query($link, $query);
	  			$row2 = mysqli_fetch_row($result);
	  			$matchUser = $row2[0];
	  			//DELETE THE CLASS TABLE TOO
	  			$query = "DROP TABLE `$tempTable`";
	  			mysqli_query($link, $query);
	  		} else {
	  			$temp = $row[3] - 1;
	  			//UPDATE QUEUE, REMOVE ONE FROM QUEUE
	  			$query = "UPDATE classsection set queue=$temp WHERE className='$className' and fromSection='$secfrom' and toSection='$secto'";
	  			mysqli_query($link, $query);
	  			//GET THE USER NAME FROM TABLE
	  			$query = "SELECT * FROM `tempTable` LIMIT 1";
	  			$result = mysqli_query($link, $query);
	  			$row2 = mysqli_fetch_row($result);
	  			$matchUser = $row2[0];
	  			//UPDATE TABLE, REMOVE ONE FROM QUEUE
	  			$query = "DELETE FROM `tempTable` WHERE userName='$matchUser'";
	  			mysqli_query($link, $query);
	  		}
	  	}
	}
  	mysqli_free_result($result);
  }
  function checkToFrom() {
  	$tempTable2 = $className.$secto.$secfrom;
  	$query = "SELECT * FROM classsection WHERE className='$className' and fromSection='$secto' and toSection='$secfrom'";
  	$result = mysqli_query($link, $query);
  	$row = mysqli_fetch_row($result);
  	if($row)
	  	if($row[3] == 1) {
	  		//UPDATE QUEUE, REMORE THE WHOLE ROW
	  		$query = "DELETE FROM classsection WHERE className='$className' and fromSection='$secto' and toSection='$secfrom'";
	  		mysqli_query($link, $query);
	  		//GET THE USER FROM TOP OF THE QUEUE
	  		$query = "SELECT * FROM `tempTable2` LIMIT 1";
	  		$result = mysqli_query($link, $query);
	  		$row2 = mysqli_fetch_row($result);
	  		$matchUser2 = $row2[0];
	  		//UPDATE TABLE, DROP THE WHOLE TABLE
	  		$query = "DROP TABLE `tempTable2`";
	  		mysqli_query($link, $query);
	  	} else {
	  		$temp = $row[3] - 1;
  			//UPDATE QUEUE, REMOVE ONE FROM QUEUE
  			$query = "UPDATE classsection set queue=$temp WHERE className='$className' and fromSection='$secto' and toSection='$secfrom'";
  			mysqli_query($link, $query);
  			//GET THE USER NAME FROM TABLE
  			$query = "SELECT * FROM `tempTable2` LIMIT 1";
  			$result = mysqli_query($link, $query);
  			$row2 = mysqli_fetch_row($result);
  			$matchUser2 = $row2[0];
  			//UPDATE TABLE, REMOVE ONE FROM QUEUE
  			$query = "DELETE FROM `tempTable2` WHERE userName='$matchUser2'";
  			mysqli_query($link, $query);
	  	}
	}
  	mysqli_free_result($result);
  }
  $query = "SELECT * FROM classsection WHERE className = '$className'";
  if($result = mysqli_query($link, $query)) {
  	$findMatch = false;
  	$hasRecord = false;
  	while ($row = mysqli_fetch_row($result)) {
         if($row[1] == $secfrom && $row[2] == $secto) {
         	$hasRecord = true;
         }
         if($row[1] == $secto && $row[2] == $secfrom) {
         	$findMatch = true;
         }
    }
    mysqli_free_result($result);
    if($hasRecord == true) {
    	if($findMatch == true) {
    		checkFromTo(false);
    		checkToFrom();
    	} else {
    		checkFromTo(true);
    	}
    } else {
    	$query = "CREATE TABLE `$className` (userName varchar(20))";
    	mysqli_query($link, $query);
    	$query = "INSERT `$tempTable` values ('$userName')";
    	mysqli_query($link, $query);
    	$query = "INSERT classsection values ('$className', '$secfrom', 'secto', 1)";
    	mysqli_query($link, $query);
    }
  }
  mysqli_close($link);
?>