<?php
	class WildBird {
		private $lights = array();
		private $defaultDimlevels = array();
		
		/**
		* Call this method to get singleton
		*
		* @return (WildBird) singleton.
		*/
		public static function Instance(){
			static $inst = null;
			if ($inst === null) {
				$inst = new WildBird();
			}
			return $inst;
		}

		protected function __clone(){}

		private function __construct(){
			# Load configurtion from file
			$config = json_decode(file_get_contents('./config/config.json'), true);
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
		
		public function on($calledName = true, $dimlevel = "default"){
			logMessage("Calling everything 'On' that matches", $calledName);
			foreach ($this->lights as $light){
				$light->on($calledName, $dimlevel);
			}
		}
	}
?>
