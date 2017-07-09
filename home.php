<?php
	# Initialize WildBird - let her fly!
	include_once("./includes/Init.inc.php");

	logMessage("Starting script");
	
	# Check mode and device
	$mode = isset($_GET['mode']) ? $_GET['mode'] : false;
	$device = isset($_GET['device']) ? $_GET['device'] : false;
	$dimlevel = isset($_GET['dimlevel']) ? $_GET['dimlevel'] : "default";

	$affectedLights = 0;
	$overallLogMessage = "";

	if($mode !== false && $device !== false) {
		$calledString = strip($device);
		
		switch($mode) {
			case "on":
				$affectedLights = WildBird::Instance()->on($calledString, $dimlevel);
				$overallLogMessage .= $affectedLights;
				$overallLogMessage .= " lights turned on (";
				$overallLogMessage .= $calledString;
				$overallLogMessage .= ")";
				
				break;
			case "dim":
				$affectedLights = WildBird::Instance()->on($calledString, $dimlevel);
				$overallLogMessage .= $affectedLights;
				$overallLogMessage .= " lights dimmed to ".$dimlevel." on (";
				$overallLogMessage .= $calledString;
				$overallLogMessage .= ")";
				break;
			case "off":
				$affectedLights = WildBird::Instance()->off($calledString);
				$overallLogMessage .= $affectedLights;
				$overallLogMessage .= " lights turned off (";
				$overallLogMessage .= $calledString;
				$overallLogMessage .= ")";
				break;
			default:
				$overallLogMessage .= "No lights affected (";
				$overallLogMessage .= $calledString;
				$overallLogMessage .= ")";
				// Todo: log
		}
	}
	
	$pushbullet = new PHPushbullet\PHPushbullet('o.V5CyTeDxQXSsT5Tx7yEHRvuz8PUjemBC');
	$pushbullet->all();
	$pushbullet->note('WildBird', $overallLogMessage . " (" . $_SERVER['REQUEST_URI'] . ")");
	
?>
