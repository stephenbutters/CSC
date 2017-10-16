<?php	
	$username = $_GET["username"];
	$userpwd = $_GET["userpwd"];
	$userphone = $_GET["userphone"];
	$useremail = $_GET["useremail"];
	if($file = fopen("userAccounts.txt", "r")) {
		while(!feof($file)) {
			$line = fgets($file);
			if($line != "") {
				$temp = explode(" ", $line);
				if(strcmp($temp[0], $username) == 0) {
					echo "1";
					return;
				}
			}
		}
	}
	$data = PHP_EOL.$username.' '.$userpwd.' '.$userphone.' '.$useremail;
	file_put_contents("userAccounts.txt", $data, FILE_APPEND | LOCK_EX);
	echo "0";
?>