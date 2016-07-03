<?php

/**
 * Base API test class
 */
class BaseAPITest extends APITestCase {
	/**
	 * Test the reponse of the api route.
	 *
	 * @return void
	 */
	public function testGetRequest() {
		$this->call('GET', '/');
		$this->assertResponseStatus(404);
	}

	/**
	 * Test the reponse of the eco.
	 *
	 * @return void
	 */
	public function testEcoGetRequest() {
		$this->call('GET', '/eco');
		$this->assertResponseStatus(404);
	}

	/**
	 * Test the reponse of the eco.
	 *
	 * @dataProvider ecoParameters
	 * @return void
	 */
	public function testEcoPostRequest($parameters, $result) {
		$response = $this->call('POST', '/eco', $parameters);
		$this->assertEquals($response->getContent(), $result);
	}

	/**
	 * Test parameters for the echo requests.
	 */
	public function ecoParameters() {
		return [
			[[], '[]'],
			[['hello' => 'world'], '{"hello":"world"}'],
			[['hello' => 'world', 'lurk' => 'laravel'], '{"hello":"world","lurk":"laravel"}'],
		];
	}
}
