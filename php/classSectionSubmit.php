<?php require_once("dbinfo.php"); ?>
<?php
/*
	THIS IS WHAT I CALL WHEN I CLICK THE SUBMIT BTN IN CHANGE SECTION PAGE
	PASS IN VALUE: $userName, $className, $secfrom, $secto
	RETURN VALUE: 0(SUCCESS), 1(SECTION EXIST), 2(REVERSE SECTION EXIST), 3(MYSQL QUERY ERROR)
*/
  function classSectionSubmit($userName, $className, $secfrom, $secto) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');

    if(mysqli_connect_errno()) {
   	  printf("Connect failed: %s\n", mysqli_connect_error());
   	  return;
    }

    //CHECK IF THE SECTION EXISTS OR NOT
    $query = "SELECT * FROM `classSectionChange` WHERE `username`='$userName' AND `class`='$className'";
    if($result = mysqli_query($link, $query)) {
      while($row = mysqli_fetch_row($result)) {
        //ALREADY EXIST, RETURN '1'
        if($row[2] == $secfrom && $row[3] == $secto) {
          return "1";
        }
        //ALREADY HAVE A REVERSE SECTION CHANGE ENTRY, RETURN '2'
        else if($row[2] == $secto && $row[3] == $secfrom) {
          return "2";
        }
        //STILL GOOD
      }
    } else {
      return "-1"; //DB ERROR
    }

    //IF NO ENTRY IN DB, FIND THE MATCH
    $query = "SELECT u.fullname, u.email FROM classSectionChange c, users u WHERE c.class='$className' AND c.secfrom='$secto' AND c.secto='$secfrom' AND c.username=u.fullname LIMIT 1";
    if($result = mysqli_query($link, $query)) {
      //IF NO ENTRY MATCHES, INSERT THE SECTION INTO DB
      if(mysqli_num_rows($result) <= 0) {
        $query = "INSERT `classSectionChange` VALUES ('$userName', '$className', '$secfrom', '$secto', curdate())";
        if(!mysqli_query($link, $query)) {
          return "-1"; //DB ERROR
        } else {
          return "0";  //SUCCESS
        }
      }
      //IF WE FIND A MATCH, GET THE USERNAME AND EMAIL
      //THEN SEND A NOTIFICAITON TO EACH OF THEM, AND DELETE THEM FROM DB
      else {
        $row0 = mysqli_fetch_row($result);
        $matchUser = $row0[0];
        $matchUserEmail = $row0[1];
        $query = "DELETE FROM `classSectionChange` WHERE `username`='$matchUser' AND `class`='$className' AND `secfrom`='$secto' AND `secto`='$secfrom'";
        if(!mysqli_query($link, $query)) {
          return "-1"; //DB ERROR
        }
        $query = "SELECT * FROM `users` WHERE `fullname`='$userName'";
        if($result = mysqli_query($link, $query)) {
          $row1 = mysqli_fetch_row($result);
          $email = $row1[1];
        } else return "-1"; //DB ERROR
        $title = "Status Update";
        $query1 = "INSERT `message` VALUES ('$userName', '$className', 0, curdate())";
        mysqli_query($link, $query1);
        $query1 = "INSERT `message` VALUES ('$matchUser', '$className', 0, curdate())";
        mysqli_query($link, $query1);
        //SEND TO CURRENT USER
        $content = format_emailContent($userName, $info, 2, $className, $secfrom, $secto, $matchUserEmail);
        send_mail($email, $userName, $title, $content);
        //SEND TO MATCH USER
        $content = format_emailContent($matchUser, $info, 2, $className, $secto, $secfrom, $email);
        send_mail($matchUserEmail, $matchUser, $title, $content);
        return "0"; //DONE
      }
    }
    else return "-1"; //DB ERROR
  	mysqli_close($link);
  }
?>