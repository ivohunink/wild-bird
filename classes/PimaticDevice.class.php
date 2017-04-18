<?php
class PimaticDevice {
	private $name;

	private $config_host = "192.168.0.108";
	private $config_user = "admin";
	private $config_passwd = "vlaamsegaai";

	function __construct($name)
	{
		$this->name = $name;
		logMessage("New Pimatic device created", $this->name);
	}

	public function getName()
	{
		return $this->name;
	}
	
	private function isSuccesfull($arrayResult)
	{
		$success = false;
		//$arrayResult = json_decode($jsonResult, true); 
		if(is_array($arrayResult) && isset($arrayResult['success']) && $arrayResult['success'] == 'true'){
			$success = true;
			logMessage("Call Succesfull");
		} else {
			logMessage("Call Unsuccesfull");
		}
		return $success;
	}

	public function getDeviceInfo(){
		$apiAction = "devices";
		$url = $this->buildPimaticBasicUrl($apiAction);
		return $this->isSuccesfull($this->callPimatic($url));
	}

	public function callDeviceAction ($deviceAction, $param = false, $paramValue = false){
		logMessage("Calling Pimatic device action", $deviceAction);
		$apiAction = "device";
		$url = $this->buildPimaticBasicUrl($apiAction);
		$url .= "/$deviceAction";
		if($param !== false){
			$url .= "?$param=$paramValue";
		}
		return $this->isSuccesfull($this->callPimatic($url));
	}

	private function buildPimaticBasicUrl($apiAction){
		# construct URL
		$url = "http://".$this->config_host."/api/$apiAction/".$this->name;
		return $url;
	}

	private function callPimatic($url){
		logMessage("Calling Pimatic API URL", $url);

		# Setup and execute CURL
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($curl, CURLOPT_USERPWD, $this->config_user . ":" . $this->config_passwd);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$curlResult = curl_exec($curl);// curl to a variable

		# Evaluate CURL execution
		if($curlResult === false) {
			logMessage('CURL error', curl_error($curl));
		} else {
			logMessage("CURL successful");
		}

		# Close CURL
		curl_close($curl);
		
		$jsonResult = json_decode($curlResult, true);// decode to associative array
		return $jsonResult;
	}
}
?>
