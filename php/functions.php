<?php
	function format_emailContent($username, $info, $register, $class, $secfrom, $secto, $email) {
		if($register == 1) {
			// $message = "Thank you for registering Bruin Switch, click to verify your email address: ".$info;
			$message = 'Hi, '.$username.'!<br><br>

						Welcome to the BruinSwitch community - where all Bruins can pair and share!<br> 

						Click <a href="'.$info.'">here</a> to verify your email and start your journey.<br><br>

						Good luck and have fun!<br><br> 


						Best Regards,<br> 
						The Team 404';
		} else if($register == 2){
			$message = 'Hi, '.$username.'!<br><br>

						We have found you a match for class: '.$class.' from section: '.$secfrom. ' to section: '.$secto.'. You can contact your partner by emailing to: '.$email.'.<br><br>

						Thank you for using BRUIN SWITCH, and GLHF!<br><br>

						Best Regards,<br>
						The Team 404';
		}
		return $message;
	}
?>
