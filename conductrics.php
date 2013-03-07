<?php

class Conductrics {
	static public $baseUrl = 'http://api.conductrics.com';
	static public $apiKey = '';
	static public $ownerCode = '';
}

class ConductricsAgent {
	function __construct($name) {
		$this->name = $name;
		$this->_baseUrl = null;
		$this->_apiKey = null;
		$this->_ownerCode = null;
	}
	public function baseUrl($value = null) {
		if( $value == null ) {
			if( $this->_baseUrl == null )
				return Conductrics::$baseUrl;
			return $this->_baseUrl;
		}
		$this->_baseUrl = $value;
		return $this;
	}
	public function ownerCode($value = null) {
		if( $value == null ) {
			if( $this->_ownerCode == null )
				return Conductrics::$ownerCode;
			return $this->_ownerCode;
		}
		$this->_ownerCode = $value;
		return $this;
	}
	public function apiKey($value = null) {
		if( $value == null ) {
			if( $this->_apiKey == null )
				return Conductrics::$apiKey;
			return $this->_apiKey;
		}
		$this->_apiKey = $value;
		return $this;
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
		$url = implode("/", array(
			$this->baseUrl(), $this->ownerCode(), $this->name,
			"decision", $num_choices
		));
		try { return $choices[
			$this->request($url,
				array(
					"session" => $session,
					"apikey" => $this->apiKey(),
					"nocache" => rand()
				)
			)->decision ];
		} catch( Exception $err ) {
			return $choices[0];
		}
	}
	public function reward($session, $goalCode = "goal-1", $value = 1.0) {
		$url = implode("/", array(
			$this->baseUrl(), $this->ownerCode(), $this->name,
			"goal", $goalCode
		));
		return $this->request($url, array(
			"reward" => $value,
			"session" => $session,
			"apikey" => $this->apiKey(),
			"nocache" => rand()
		));
	}
	public function expire($session) {
		$url = implode("/", array(
			$this->baseUrl(), $this->ownerCode(), $this->name,
			"expire"
		));
		return $this->request($url, array(
			"session" => $session,
			"apikey" => $this->apiKey(),
			"nocache" => rand()
		));
	}

}

?>
