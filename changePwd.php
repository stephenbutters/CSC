<?php
	$username = $_GET["username"];
	$usernewpwd = $_GET["userpwd"];
	$useremail = $_GET["useremail"];
	$newline = array();
	$findmatch = 0;
	$oldphone = "";
	if($file = fopen("userAccounts.txt", "r")) {
		while(!feof($file)) {
			$line = fgets($file);
			if($line != "") {
				$temp = explode(" ", $line);
				$temp[3] = trim(preg_replace('/\s+/', '', $temp[3]));
				if(strcmp($temp[0], $username) == 0 && strcmp($temp[3], $useremail) == 0) {
					$oldphone = $temp[2];
					$findmatch = 1;
				} else {
					$newline[] = $line;
				}
			}
		}
	}
	if($findmatch == 0) {
		echo "1";
		return;
	}
	$fp = fopen("userAccounts.txt", "w+");
	flock($fp, LOCK_EX);
	foreach($newline as $entry) {
		fwrite($fp, $entry);
	}
	$updateOne = PHP_EOL.$username.' '.$usernewpwd.' '.$oldphone.' '.$useremail;
	fwrite($fp, $updateOne);
	flock($fp, LOCK_UN);
	fclose($fp);
	echo "0";
?>