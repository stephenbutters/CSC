<?php
require "php/registerusers.php";
require "php/userValidate.php";
require "php/changePwd.php";
require "php/classSectionSubmit.php";
require "php/removeClassSection.php";
require "php/updateClassSection.php";
$username = $_GET['username'];
$pwd = $_GET['pwd'];
$newpwd = $_GET['newpwd'];
$email = $_GET['email'];
$phone = $_GET['phone'];
$secfrom = $_GET['secfrom'];
$secto = $_GET['secto'];
$action = $_GET['action'];
$classname = $_GET['class'];
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
}
?>