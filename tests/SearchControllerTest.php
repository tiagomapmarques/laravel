<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;

class SearchControllerTest extends TestCase {
	/**
	 * Test the search functionality
	 * TODO: perform a search inside the page
	 *
	 * @dataProvider searchData
	 * @return void
	 */
	public function testSearch($query, $result) {
		if(is_null($result)) {
			$User = User::all()->first();
			$query = explode('@', $User->email)[0];
			$result .= $User->email;
		}

		// test search page 200 response code
		$this->visit('/search')
			->assertResponseOk();

		// create the search url
		$url = '/search'.(strlen($query)>0? '?q='.urlencode(str_replace(' ', '+', $query)) : '');

		// test if the search is performed correctly
		$this->visit($url)
			->seePageIs($url)
			->seeElement('#search-bar input', ['value' => $query])
			->see($result);
	}

	/**
	 * Function to set up the test environment for each test
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$User = factory(User::class)->create();
	}

	/**
	 * Function to provide data for the tests
	 *
	 * @return array(array)
	 */
	public function searchData() {
		return array(
			array('', null),
			array(Helper::generateRandomString(), '0 results'),
			array(Helper::generateRandomString().' ', null),
			array('*', '0 results'),
			array('', '0 results'),
		);
	}
}
