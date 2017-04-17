<?php
class SwitchLight extends AbstractLight {
	private $dimlevels;

	function __construct($switchlightConfig){
		parent::__construct($switchlightConfig);
	}	
	
	/*
	 * function turnOn
	 *
	 * Turns the light on.
	 *
	 * @dimlevel (string) Optional dimlevel
	 */
	protected function turnOn($dimlevel = "default") {
		$device = new PimaticDevice($this->name);
		$device->callDeviceAction("turnOn");
	}
} 
?>
