<?php
	function logMessage($label, $message = ""){
		$finalMessage = date("Y-m-d H:i:s") ."  |  $label";
		if ($message != "") {
			$finalMessage .= ": " . $message;
		}
		echo($finalMessage ."<BR>");
		error_log($finalMessage ."\n", 3, "/var/tmp/home.log");
	}
?>
