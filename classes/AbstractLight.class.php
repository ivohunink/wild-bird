<?php
abstract class AbstractLight {
	protected $name;
	protected $synonyms = array();
	protected $groups = array();		

	function __construct($lightConfig){
		$this->name = $lightConfig['name'];
		if(isset($lightConfig['groups'])){
			$this->groups = $lightConfig['groups'];
		}
		if(isset($lightConfig['synonyms'])){
			$this->synonyms = $lightConfig['synonyms'];
		}
	}
	
	/*
	 * function on
	 *
	 * Checks if the light is called, and then turns the light on.
	 *
	 * @dimlevel (string) Optional dimlevel.
	 */
	public function on($calledName = true, $dimlevel = "default") {
		if($this->isCalled($calledName) or $calledName === true){
			$this->turnOn($dimlevel);
		}
	}

	/*
	 * function off
	 *
	 * Checks if the light is called, and then turns the light off.
	 */
	public function off($calledName = true) {
		if($this->isCalled($calledName) or $calledName === true){
			logMessage("Turn off", $this->name);
			$this->turnOff();
		}
	}
	
	/*
	 * function turnOn
	 *
	 * Turns the light on.
	 *
	 * @dimlevel (string) Optional dimlevel.
	 */
	abstract protected function turnOn($dimlevel = "default");

	/*
	 * function turnOff
	 *
	 * Turns the light off.
	 */
	private function turnOff() {
		$device = new PimaticDevice($this->name);
		$device->callDeviceAction("turnOff");
	}

	/*
	 * function getName
	 *
	 * Returns name of light.
	 *
	 * @return (string)
	 */
	public function getName(){
		return $this->name();
	}

	/*
	 * function getSynonyms
	 *
	 * Returns synonyms of light.
	 *
	 * @return (array)
	 */
	public function getSynonyms(){
		return $this->synonyms();
	}

	/*
	 * function getGroups
	 *
	 * Returns groups of which this light is part of.
	 *
	 * @return (string)
	 */
	public function getGroups(){
		return $this->groups();
	}

	/*
	 * function isCalled
	 *
	 * Returns true if this light is called (check against name, synonyms, and groups.
	 *
	 * @return (array)
	 */
	public function isCalled($calledName){
		$isCalled = false;
		if($this->name == $calledName or in_array($calledName, $this->synonyms) or in_array($calledName, $this->groups)){
			$isCalled = true;
			logMessage("Called", $calledName);	
		}
		return $isCalled;
	}
}
?>
