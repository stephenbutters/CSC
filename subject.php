<?php
	$fileName = $_GET["name"];
	if($file = fopen($fileName.".txt", "r")) {
		while(!feof($file)) {
			$line = fgets($file);
			if($line != "") {
				$allSubjects .= $line;
				if(!feof($file)) $allSubjects .= '*';
			}
		}
	}
	echo $allSubjects;
?>