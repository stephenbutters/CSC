<?php
	function format_emailContent($username, $info, $register, $class, $secfrom, $secto, $email) {
		if($register == 1) {
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
		} else if($register == 3) {
			$message = 'Hi, '.$username.'!<br><br>

						You have join the team: '.$info.' for class: '.$class.' in section: '.$secfrom.', and you can contact the current team leader by emailing to: '.$email.'.<br><br>

						Thank you for using BRUIN SWITCH, and GLHF!<br><br>

						Best Regards,<br>
						The Team 404';
		} else if($register == 4) {
			$message = 'Hi, '.$username.'!<br><br>

						Congrats. Your team '.$info.' for class '.$class.' in section '.$secfrom.' has been full.<br><br>
						You can contact your joined team member(s) by emailing to: '.$email.'.<br><br>

						Thank you for using BRUIN SWITCH, and GLHF!<br><br>

						Best Regards,<br>
						The Team 404';
		} else if($register == 5) {
			$message = 'HI, '.$username.'!<br><br>

						We have found you a match for Parking Permit Switch section from: '.$secfrom.', to section: '.$secto.'. You can contact your partner by emailing to: '.$email.'.<br><br>

						Thank you for using BRUIN SWITCH, and GLHF!<br><br>

						Best Regards,<br>
						The Team 404';
		}
		return $message;
	}
?>
