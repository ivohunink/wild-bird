<?php
	# Initialize WildBird - let her fly!
	include_once("./includes/Init.inc.php");

	logMessage("Starting script");
	
	$pushbullet = new PHPushbullet\PHPushbullet('o.V5CyTeDxQXSsT5Tx7yEHRvuz8PUjemBC');
	$pushbullet->all();
	$pushbullet->note('WildBird', $_SERVER['REQUEST_URI']);
	
	# Check mode and device
	isset($_GET['mode']) ? $_GET['mode'] : false;
	isset($_GET['device']) ? $_GET['device'] : false;
	$mode = $_GET['mode'];
	$device = $_GET['device'];

	if($mode !== false && $device !== false) {
		$deviceName = strip($device);
		
		switch($mode) {
			case "on":
				isset($_GET['dimlevel']) ? $_GET['dimlevel'] : "default";
				$dimlevel = $_GET['dimlevel'];
				WildBird::Instance()->on($deviceName, $dimlevel);
				break;
			case "dim":
				isset($_GET['dimlevel']) ? $_GET['dimlevel'] : "default";
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
