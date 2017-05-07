<?php
	# Initialize WildBird - let her fly!
	include_once("./includes/Init.inc.php");

	logMessage("Starting script");
	
	$pushbullet = new PHPushbullet\PHPushbullet('o.V5CyTeDxQXSsT5Tx7yEHRvuz8PUjemBC');
	$pushbullet->all();
	$pushbullet->note('WildBird', $_SERVER['REQUEST_URI']);
	
	# Check mode and device
	$mode = isset($_GET['mode']) ? $_GET['mode'] : false;
	$device = isset($_GET['device']) ? $_GET['device'] : false;
	$dimlevel = isset($_GET['dimlevel']) ? $_GET['dimlevel'] : "default";

	if($mode !== false && $device !== false) {
		$deviceName = strip($device);
		
		switch($mode) {
			case "on":
				WildBird::Instance()->on($deviceName, $dimlevel);
				break;
			case "dim":
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
