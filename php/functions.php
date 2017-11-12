<?php
	function format_emailContent($username, $info, $register) {
		if($register) {
			// $message = "Thank you for registering Bruin Switch, click to verify your email address: ".$info;
			$message = 'Hi, '.$username.'!<br><br>

						Welcome to the BruinSwitch community - where all Bruins can pair and share!<br> 

						Click <a href="'.$info.'">here</a> to verify your email and start your journey.<br><br>

						Good luck and have fun!<br><br> 


						Best Regards,<br> 
						The Team 404';
		} else {
			$message = "We have found you a match for class: ".$info["class"]." section: ".$info["section"]. ". You can contact your partner by email: ".$info["email"].".";
		}
		return $message;
	}
?>