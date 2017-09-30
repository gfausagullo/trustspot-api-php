<?php

class TrustSpotApiClient extends PHPUnit_Framework_TestCase{

	public function testIsThereAnySyntaxError(){
		$var = new Gonzaloner\TrustSpotApiClient\TrustSpotApiClient;
		$this->assertTrue(is_object($var));
		unset($var);
	}
}
