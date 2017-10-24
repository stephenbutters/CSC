<?php
	$username = $_GET["username"];
	$userpwd = $_GET["userpwd"];
	if($file = fopen("userAccounts.txt", "r")) {
		while(!feof($file)) {
			$line = fgets($file);
			if($line != "") {
				$temp = explode(" ", $line);
				if($temp[0] == $username && $temp[1] == $userpwd) {
					echo "0";
					return;
				}
			}
		}
	}
	echo "1";
?>