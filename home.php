<?php
	# Include Init file
	include_once("./includes/Init.inc.php");
	# Error reporting on
	error_reporting(E_ALL);
	logMessage("Starting script");
	# Check mode
	if(isset($_GET["mode"])){
		$mode = $_GET["mode"];
		
		$tempDeviceName = false;
		if(isset($_GET["device"])){
			$tempDeviceName = strip($_GET["device"]);
		}

		# In case of mode for specific device or group of devices
		if($mode == "on" or $mode == "dim"){
			logMessage("On", $tempDeviceName);
			$wildbird->on($tempDeviceName);
		} else {
			logMessage("Off", $tempDeviceName);
			$wildbird->off($tempDeviceName);
		}
	}
?>
