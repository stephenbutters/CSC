<?php include "secretInfo.php"; ?>
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
		$mail->Host = 'smtp.qq.com';
		$mail->Username = "78570685@qq.com";
		$mail->Password = PWD;
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		$mail->SetFrom("78570685@qq.com", "Bruin Switch");
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

