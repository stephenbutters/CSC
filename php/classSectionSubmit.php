<?php require_once("dbinfo.php"); ?>
<?php
/*
	THIS IS WHAT I CALL WHEN I CLICK THE SUBMIT BTN IN CHANGE SECTION PAGE
	PASS IN VALUE: $userName, $className, $secfrom, $secto
	RETURN VALUE: 0(SUCCESS), 1(SECTION EXIST), 2(REVERSE SECTION EXIST), 3(MYSQL QUERY ERROR)
*/
  function classSectionSubmit($userName, $className, $secfrom, $secto) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if(mysqli_connect_errno()) {
   	  printf("Connect failed: %s\n", mysqli_connect_error());
   	  return;
    }

    //CHECK IF THE SECTION EXISTS OR NOT
    $query = "SELECT * FROM $userName WHERE className='$className'";
    if($result = mysqli_query($link, $query)) {
    	while($row = mysqli_fetch_row($result)) {
    		//ALREADY EXIST, RETURN '1'
    		if($row[1] == $secfrom && $row[2] == $secto) {
    			return "1";
    		}
    		//ALREADY HAVE A REVERSE SECTION CHANGE ENTRY, RETURN '2'
    		else if($row[1] == $secto && $row[2] = $secfrom) {
    			return "2";
    		}
    		//STILL GOOD
    	}
    	mysqli_free_result($result);
          //LOOK UP THE CLASS SECTION TABLE
      $tempTable = $className.$secfrom.$secto;
      //CHECK IF TABLE EXIST
      $query = "SELECT * FROM `$tempTable`";
      if($result = mysqli_query($link, $query)) {
        //TABLE EXISTS, CHECK HOW MANY ENTRIES UP THERE
        //IF MORE THAN 1 ENTRY, INSERT USERNAME TO THE TABLE
        if(mysqli_num_rows($result) != 0) {
          $query = "INSERT `$tempTable` values ('$userName')";
          if(!mysqli_query($link, $query)) {
            return "3";
          }
          $query = "INSERT $userName values ('$className', '$secfrom', '$secto', curdate())";
          if(!mysqli_query($link, $query)) {
            return "3";
          }
          return "0";
        }
        mysqli_free_result($result);
      } else {
        //IF NOT EXIST, CREATE ONE
        $query = "CREATE TABLE `$tempTable` (userName varchar(20))";
        if(!mysqli_query($link, $query)) {
          return "3";
        }
      }

      //LOOK UP THE MATCH CLASS SECTION TABLE
      $tempTable2 = $className.$secto.$secfrom;
      $query = "SELECT * FROM `$tempTable2`";
      if($result = mysqli_query($link, $query)) {
        //IF IT HAS ENTRY, DELETE THE FIRST ENTRY FRON MATCH CLASS SECTION TABLE
        //AND THEN SEND EMAILS TO THE MATCHES
        if(mysqli_num_rows($result) != 0) {
          $row0 = mysqli_fetch_row($result);
          $matchUser = $row0[0];
          $query = "DELETE FROM `$tempTable2` WHERE userName='$matchUser'";
          if(!mysqli_query($link, $query)) {
            return "3"; //ERROR
          }
          //DELETE THAT CLASS SECTION FROM MATCH USER
          $query = "DELETE FROM $matchUser WHERE className='$className' and secfrom='$secto' and secto='$secfrom'";
          if(!mysqli_query($link, $query)) {
            return "3";
          }
          /*
          SEND EMAIL TO $userName and $matchUser, THEN EXIT
          */
          return "0";
        }
    	}
      //IF THE TABLE DOESN'T EXIST OR THE TABLE HAS NO ENTRY
      //INSERT CLASSNAME TO USERNAME TABLE, AND INSERT USRENAME TO CLASS SECTION TABLE 
      $query = "INSERT `$tempTable` values ('$userName')";
      if(!mysqli_query($link, $query)) {
        return "3";
      }
      $query = "INSERT $userName values ('$className', '$secfrom', '$secto', curdate())";
      if(!mysqli_query($link, $query)) {
        return "3";
      } 
    }
  	return "0";
  	mysqli_close($link);
  }
?>