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

		public function off($calledString = true){
			$affectedLigths = 0;
			logMessage("Calling everything 'Off' that matches", $calledString);
			foreach ($this->lights as $light){
				if($light->off($calledString, $dimlevel)){
					$affectedLigths++;
				}
			}
			return $affectedLigths;
		}
		
		public function on($calledString = true, $dimlevel = "default"){
			$affectedLigths = 0;
			logMessage("Calling everything 'On' that matches", $calledString);
			logMessage("Dimlevel",$dimlevel);
			foreach ($this->lights as $light){
				if($light->on($calledString, $dimlevel)){
					$affectedLigths++;
				}
			}
			return $affectedLigths;
		}
	}
?>
