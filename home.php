<?php
	# Include classes
	include("PimaticDevice.class.php");
	include("Functions.inc.php");
	
	# Error reporting on
	error_reporting(E_ALL);

	# Init variables
	logMessage("Starting script");
	$deviceName = false;
	$mode = false;
	$devices = array();
	
	$devices['hallway'] = 'hal';
	$devices['couch'] = 'bank';
	$devices['sofa'] = 'bank';
	$devices['television'] = 'televisie-meubel';
	$devices['dining room'] = 'eettafel';
	$devices['dining table'] = 'eettafel';
	$devices['kitchen'] = 'keuken';
	$devices['coffee-corner'] = 'koffie-corner';

	# Check mode
	if(isset($_GET["mode"])){
		$mode = $_GET["mode"];
		
		# In case of mode for specific device
		if($mode == "on" or $mode == "off" or $mode == "dim"){
			logMessage("Mode for specific Pimatic device", $mode);
			$tempDeviceName = trim($_GET["device"]);
			$tempDeviceName = str_replace("the", "", $tempDeviceName);
			$tempDeviceName = str_replace("at", "", $tempDeviceName);
			$tempDeviceName = str_replace("its", "", $tempDeviceName);
			$tempDeviceName = str_replace("it's", "", $tempDeviceName);
			$tempDeviceName = str_replace("of", "", $tempDeviceName);
			$tempDeviceName = trim($tempDeviceName);

			if(isset($devices[$tempDeviceName])) {
				$deviceName = $devices[$tempDeviceName];
			}

			logMessage("Searching for Pimatic device", $tempDeviceName);

			if ($deviceName !== false){
				$device = new PimaticDevice($deviceName);
				if($_GET["mode"] == "on"){
					# Test
					$device->callDeviceAction("changeDimlevelTo", "dimlevel", "50");
				} else if ($_GET["mode"] == "dim"){
					$device->callDeviceAction("changeDimlevelTo", "dimlevel", trim($_GET["dimlevel"]));
				} else {
					$device->callDeviceAction("changeDimlevelTo", "dimlevel", "0");
				}
			} else {
				logMessage("Pimatic device not found", $tempDeviceName);
			}
		} else if ($mode == "all-off" or $mode == "all-on" or $mode == "all-dim" or $mode == "romantic"){
			logMessage("Mode for all Pimatic devices", $mode);
			$dimlevel = 0;
			if($mode == "all-dim" && isset($_GET["dimlevel"])){
				$dimlevel = trim($_GET["dimlevel"]);
			} else if($mode == "romantic"){
				$dimlevel = 28;
			} else if($mode == "all-on"){
				$dimlevel = 50;
			}
			$deviceNames = array_flip($devices);	
			foreach ($deviceNames as $deviceName => $temp) {
				logMessage("Dimming ($dimlevel)", $deviceName);
				$device = new PimaticDevice($deviceName);
				$device->callDeviceAction("changeDimlevelTo", "dimlevel", $dimlevel);
			}
		}
	}
?>
