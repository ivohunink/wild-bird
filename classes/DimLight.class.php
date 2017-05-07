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
	}	

	/*
	 * function getDimlevel
	 *
	 * Returns dimlevel of for dimlevel string.
	 *
	 * @return (int)
	 */
	public function getDimlevel($dimlevel){
		$intDimlevel = 50;
	
		if (isset($this->dimlevels[$dimlevel])) {
			$intDimlevel = $this->dimlevels[$dimlevel];
		} else if (isset($this->dimlevels["default"])){
			$intDimlevel = $this->dimlevels["default"];
		}
	
		return $intDimlevel;
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
		$device->callDeviceAction("changeDimlevelTo", "dimlevel", $this->getDimlevel($dimlevel));
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
