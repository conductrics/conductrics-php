<?php

class Conductrics {
	static public $baseUrl = 'http://api.conductrics.com';
	static public $apiKey = '';
	static public $ownerCode = '';
}

class ConductricsAgent {
	function __construct($name) {
		$this->name = $name;
	}
	private function request($url, $params) {
		if( count($params) > 0 ) {
			$url .= "?";
			foreach ($params as $key => $value) {
				$url .= $key . "=" . $value . "&";
			}
		}
		return json_decode(file_get_contents($url));
	}
	public function decide($session /*, choices... */) {
		$choices = array_slice(func_get_args(), 1);
		$num_choices = count($choices);
		$url = Conductrics::$baseUrl . "/"
			. Conductrics::$ownerCode . "/"
			. $this->name . "/decision/" . $num_choices;
		$decision = $this->request($url, array(
			"session" => $session,
			"apikey" => Conductrics::$apiKey
		));
		return $choices[$decision->decision % $num_choices];
	}
	public function reward($session, $goalCode = "goal-1", $value = 1.0) {
		$url = Conductrics::$baseUrl . "/"
			. Conductrics::$ownerCode . "/"
			. $this->name . "/goal/" . $goalCode;
		return $this->request($url, array(
			"reward" => $value,
			"session" => $session,
			"apikey" => Conductrics::$apiKey
		));
	}
}

?>
