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
}
?>