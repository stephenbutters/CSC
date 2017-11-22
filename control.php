<?php
require "php/registerusers.php";
require "php/userValidate.php";
require "php/changePwd.php";
require "php/classSectionSubmit.php";
require "php/removeClassSection.php";
require "php/updateClassSection.php";
require "php/raiseTeam.php";
require "php/updateGroup.php";
require "php/updateGroupMain.php";
require "php/removeGroupSection.php";
require "php/joinTeams.php";
require "php/updateMesg.php";
require "php/getMesg.php";
require "php/submitParking.php";
require "php/updateParking.php";
require "php/removeParkingSection.php";
$username = $_GET['username'];
$pwd = $_GET['pwd'];
$newpwd = $_GET['newpwd'];
$email = $_GET['email'];
$phone = $_GET['phone'];
$secfrom = $_GET['secfrom'];
$secto = $_GET['secto'];
$action = $_GET['action'];
$classname = $_GET['class'];
$leader = $_GET['leader'];
$remain = $_GET['remain'];
$descs = $_GET['desc'];
$teamname = $_GET['teamname'];
$parkingFrom = $_GET['pfrom'];
$parkingTo1 = $_GET['pto1'];
$parkingTo2 = $_GET['pto2'];
switch($action) {
	case "userValidate":
		echo userValidate($username, $pwd);
		break;
	case "changePwd":
		echo changePwd($username, $newpwd, $email, $phone);
		break;
	case "registerUser":
		echo registerUser($email, $username, $pwd, $phone);
		break;
	case "classSectionSubmit":
		echo classSectionSubmit($username, $classname, $secfrom, $secto);
		break;
	case "removeClassSection":
		echo removeClassSection($username, $classname, $secfrom, $secto);
		break;
	case "updateClassSection":
		echo updateClassSection($username);
		break;
	case "raiseTeam":
		echo raiseTeam($leader, $teamname, $classname, $secfrom, $remain, $descs);
		break;
	case "updateGroup":
		echo updateGroup($classname, $username);
		break;
	case "updateGroupMain":
		echo updateGroupMain($username);
		break;
	case "removeGroupSection":
		echo removeGroupSection($username, $teamname, $classname, $secfrom);
		break;
	case "joinTeams":
		echo joinTeams($username, $teamname, $classname, $secfrom);
		break;
	case "updateMesg":
		updateMesg($username);
		break;
	case "getMesg":
		echo getMesg($username);
		break;
	case "submitParking":
		echo submitParking($username, $parkingFrom, $parkingTo1, $parkingTo2);
		break;
	case "updateParking":
		echo updateParking($username);
		break;
	case "removeParkingSection":
		echo removeParkingSection($username);
		break;
}
?>