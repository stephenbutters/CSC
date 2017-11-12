<?php
	function format_emailContent($info, $register) {
		if($register) {
			$message = "Thank you for registering Bruin Switch, click to verify your email address: ".$info;
		} else {
			$message = "We have found you a match for class: ".$info["class"]." section: ".$info["section"]. ". You can contact your partner by email: ".$info["email"].".";
		}
		return $message;
	}
?>