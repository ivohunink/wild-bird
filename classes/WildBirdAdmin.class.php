<?php
	class WildBirdAdmin {
		private $lights = array();
		private $defaultDimlevels = array();

		function __construct($config){
			$this->defaultDimlevels = $config['dimlevels'];
			foreach ($config['switchlights'] as $switchlightConfig){
				$switchlight = new SwitchLight($switchlightConfig);
				$this->lights[] = $switchlight;
			}
			foreach ($config['dimlights'] as $dimlightConfig){
				$dimlight = new DimLight($dimlightConfig, $this->defaultDimlevels);
				$this->lights[] = $dimlight;
			}
		}

		public function off($calledName = true){
			logMessage("Calling everything 'Off' that matches", $calledName);
			foreach ($this->lights as $light){
				$light->off($calledName);
			}
		}
		
		public function on($calledName = true){
			logMessage("Calling everything 'On' that matches", $calledName);
			foreach ($this->lights as $light){
				$light->on($calledName);
			}
		}
	}
?>
