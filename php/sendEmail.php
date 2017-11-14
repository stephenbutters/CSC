<?php require_once("secretInfo.php"); ?>
<?php
	header("content-type: text/html; charset-utf-8");
	require 'PHPMailer/class.phpmailer.php';
	require 'PHPMailer/class.smtp.php';

	function send_mail($to, $username, $title, $content) {
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		$mail->CharSet='UTF-8';
		$mail->SMTPDebug = 2;
		$mail->SMTPAuth = true;
		$mail->Host = 'smtp-mail.outlook.com';
		$mail->Username = "hongkanliu@hotmail.com";
		$mail->Password = "091013kanye.";
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->SetFrom("hongkanliu@hotmail.com", "Bruin Switch");
		$mail->AddAddress($to, $username);
		$mail->IsHTML(true);
		$mail->Subject = $title;
		$mail->Body = $content;
		if($mail->send())
			echo "0";
		else
			echo "1";
	}
?>

