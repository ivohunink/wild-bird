<?php
class DimLight extends AbstractLight {
	private $dimlevels;

	function __construct($dimlightConfig, $defaultDimlevels){
		parent::__construct($dimlightConfig);
		if(isset($dimlightConfig['dimlevels'])){
			$this->dimlevels = array_merge($defaultDimlevels, $dimlightConfig['dimlevels']);
		} else {
			$this->dimlevels = $defaultDimlevels;
		}
		print_r($this->dimlevels);
	}	
	
	/*
	 * function getDimlevels
	 *
	 * Returns dimlevels of light.
	 *
	 * @return (array)
	 */
	public function getDimlevels(){
		return $this->dimlevels();
	}

	/*
	 * function dim
	 *
	 * Dims the light to dimlevel.
	 *
	 * @dimlevel (string) Optional dimlevel
	 */
	private function dim($dimlevel = "default") {
		logMessage("Dimlevel",$dimlevel);
		$device = new PimaticDevice($this->name);
		$device->callDeviceAction("changeDimlevelTo", "dimlevel", $this->dimlevels[$dimlevel]);
	}
	
	/*
	 * function turnOn
	 *
	 * Turns the light on.
	 *
	 * @dimlevel (string) Optional dimlevel
	 */
	protected function turnOn($dimlevel = "default") {
		logMessage("Dimlevel",$dimlevel);
		$this->dim($dimlevel);
	}
} 
?>
