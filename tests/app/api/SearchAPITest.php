<?php

/**
 * Search API test class
 */
class SearchAPITest extends APITestCase {
	/**
	 * Test the reponse of the home page.
	 *
	 * @return void
	 */
	public function testGetRequest() {
		$this->call('GET', '/search');
		$this->assertResponseStatus(404);
	}

	/**
	 * Test the reponse of the search.
	 *
	 * @dataProvider searchParameters
	 * @return void
	 */
	public function testPostRequest($parameters, $result) {
		// if we need to fill the query string and result with the correct mock user
		if(array_key_exists('q', $parameters) && is_null($parameters['q'])) {
			$parameters['q'] = $this->User->name;
			$result = '{"user":[{"id":'.$this->User->id.
				',"hash":"'.$this->User->hash.
				'","name":"'.$this->User->name.
				'","email":"'.$this->User->email.
				'","image":"'.$this->User->image.
				'","role_id":"'.$this->User->role_id.
				'","created_at":"'.$this->User->created_at.
				'","updated_at":"'.$this->User->updated_at.'"}]}';
		}
		$response = $this->call('POST', '/search', $parameters);
		$this->assertEquals($response->getContent(), $result);
	}

	/**
	 * Test parameters for the search requests.
	 */
	public function searchParameters() {
		return [
			[[], '{"user":[]}'],
			[['query' => 'content'], '{"user":[]}'],
			[['q' => 'content'], '{"user":[]}'],
			[['q' => 'body', 'query' => 'content'], '{"user":[]}'],
			[['q' => null, 'query' => 'content'], null],
		];
	}
}
