<?php
	# Include Init file
	include_once("./includes/Init.inc.php");
		
	# Error reporting on
	error_reporting(E_ALL);

	# Init variables
	$deviceName = false;
	$deviceGroup = false;
	$mode = false;
	$devices = array();
	$affectedDevices = array();
	
	# Define devices, groups and dimlevels
	$devices['hallway'] = 'hal';
	$devices['couch'] = 'bank';
	$devices['four'] = 'bank';
	$devices['television'] = 'televisie-meubel';
	$devices['three'] = 'televisie-meubel';
	$devices['dining table'] = 'eettafel';
	$devices['two'] = 'eettafel';
	$devices['kitchen light'] = 'keuken';
	$devices['one'] = 'keuken';
	$devices['coffee corner'] = 'koffie-corner';
	$devices['zero'] = 'koffie-corner';

	$groups = array();
	$groups['dining room'] = 'eettafel';
	$groups['living room'] = 'bank,televisie-meubel';
	$groups['kitchen'] = 'keuken,koffie-corner';

	$dimlevels = array();
	$dimlevels['max'] = 100;
	$dimlevels['high'] = 80;
	$dimlevels['medium'] = 50;
	$dimlevels['low'] = 28;
	$dimlevels['default'] = 50;

	logMessage("Starting script");
	# Check mode
	if(isset($_GET["mode"])){
		$mode = $_GET["mode"];
		
		# In case of mode for specific device or group of devices
		if($mode == "on" or $mode == "off" or $mode == "dim"){
			$tempDeviceName = false;
			if(isset($_GET["device"])){
				$tempDeviceName = strip($_GET["device"]);
			}
			if($tempDeviceName !== false && isset($groups[$tempDeviceName])) {
				logMessage("Searching for Pimatic device group", $tempDeviceName);
				$deviceGroup = $groups[$tempDeviceName];
				$affectedDevices = explode(",", $deviceGroup);
			} else if($tempDeviceName !== false && isset($devices[$tempDeviceName])) {
				logMessage("Searching for Pimatic device", $tempDeviceName);
				$deviceName = $devices[$tempDeviceName];
				$affectedDevices[] = $deviceName;
			} else if($tempDeviceName !== false && $tempDeviceName == "all"){
				logMessage("Mode for all Pimatic devices", $mode);
				#$deviceNames = array_flip($devices);	
				$affectedDevices = $devices;
			}
		}

		$dimlevel = 0;
		if($mode == "dim" && isset($_GET["dimlevel"]) && isset($dimlevels[strip($_GET['dimlevel'])])){
			$dimlevel = $dimlevels[strip($_GET["dimlevel"])];
		} else if($mode == "on"){
			$dimlevel = $dimlevels['medium'];	
		}

		foreach ($affectedDevices as $deviceName) {
			logMessage("Dimming ($dimlevel)", $deviceName);
			$device = new PimaticDevice($deviceName);
			$device->callDeviceAction("changeDimlevelTo", "dimlevel", $dimlevel);
		}
	}
?>
