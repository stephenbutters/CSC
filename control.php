<?php
	include "php/userValidate.php";
	include "php/changePwd.php";
	include "php/registerusers.php";
	include "php/classSectionSubmit.php";
	include "php/removeClassSection.php";
	include "php/subject.php";
	include "php/updateClassSection.php";
?>
<?php
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
	case "getSubject":
		echo getSubject();
		break;
	case "updateClassSection":
		echo updateClassSection($username);
		break;
}

?>