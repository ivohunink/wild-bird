<?php
	function logMessage($label, $message = ""){
		$finalMessage = date("Y-m-d H:i:s") ."  |  $label";
		if ($message != "") {
			$finalMessage .= ": " . $message;
		}
		echo($finalMessage ."<BR>");
		error_log($finalMessage ."\n", 3, "/var/tmp/home.log");
	}
	
	function strip($string){
		$string = strtolower(trim($string));
		$string = str_replace("the ", "", $string);
		$string = str_replace("at ", "", $string);
		$string = str_replace("its ", "", $string);
		$string = str_replace("it's ", "", $string);
		$string = str_replace("of ", "", $string);
		$string = str_replace("all ", "", $string);
		$string = trim($string);
		return $string;
	}

	function load_config(){
		$config = json_decode(file_get_contents('./config/config.json'), true);
		$wildbird = new WildBirdAdmin($config);
		return $wildbird;
	}
?>
