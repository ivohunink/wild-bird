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
	public function on($calledString = true, $dimlevel = "default") {
		$called = false;
		if($this->isCalled($calledString) or $calledString === true){
			$this->turnOn($dimlevel);
			$called = true;
		}
		return $called;
	}

	/*
	 * function off
	 *
	 * Checks if the light is called, and then turns the light off.
	 */
	public function off($calledString = true) {
		$called = false;
		if($this->isCalled($calledString) or $calledString === true){
			logMessage("Turn off", $this->name);
			$this->turnOff();
			$called = true;
		}
		return $called;
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
	public function isCalled($calledString){
		$isCalled = false;
		//Old method for checking, in which we check whether or not the name is exactly the same as the called name
		//if($this->name == $calledString or in_array($calledString, $this->synonyms) or in_array($calledString, $this->groups)){
		//	$isCalled = true;
		//	logMessage("Called", $calledString);	
		//}

		//New method for checking, in which we check whether or not the name is mentioned in the called string
		if(stristr($calledString, $this->name)){
			$isCalled = true;
			logMessage("Called", $calledString . " (Matched against name: ".$this->name.")");	
		}
		foreach($this->synonyms as $synonym){
			if(stristr($calledString, $synonym)){
				$isCalled = true;
				logMessage("Called", $calledString . " (Matched against synonym: ".$synonym.")");	
			}
		}		
		foreach($this->groups as $group){
			if(stristr($calledString, $group)){
				$isCalled = true;
				logMessage("Called", $calledString . " (Matched against group: ".$group.")");	
			}
		}		
		
		return $isCalled;
	}
}
?>
