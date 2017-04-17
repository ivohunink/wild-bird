<?php
	# Initialize WildBird - let her fly!
	include_once("./includes/Init.inc.php");

	logMessage("Starting script");

	# Check mode and device
	isset($_GET['mode']) ? $_GET['mode'] : false;
	isset($_GET['device']) ? $_GET['device'] : false;
	$mode = $_GET['mode'];
	$device = $_GET['device'];

	if($mode !== false && $device !== false) {
		$deviceName = strip($device);
		
		switch($mode) {
			case "on":
				WildBird::Instance()->on($deviceName);
				break;
			case "dim":
				isset($_GET['dimlevel']) ? $_GET['dimlevel'] : "full";
				$dimlevel = $_GET['dimlevel'];
				WildBird::Instance()->on($deviceName, $dimlevel);
				break;
			case "off":
				WildBird::Instance()->off($deviceName);
				break;
			default:
				// Todo: log
		}
	}
?>
