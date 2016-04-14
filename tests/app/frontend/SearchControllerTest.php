<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;

/**
 * SearchController test class
 */
class SearchControllerTest extends TestCase {

	protected $User = null;

	/**
	 * Test the search functionality.
	 * TODO: perform a search inside the page
	 *
	 * @dataProvider searchData
	 * @param  string      $query
	 * @param  string|null $result
	 * @return void
	 */
	public function testSearch($query, $result) {
		if(is_null($result)) {
			$query = explode('@', $this->User->email)[0];
			$result .= $this->User->email;
		}

		// test search page 200 response code
		$this->visit('/search')
			->assertResponseOk();

		// create the search url
		$url = '/search'.(strlen($query)>0? '?q='.urlencode(str_replace(' ', '+', $query)) : '');

		// test if the search is performed correctly
		$this->visit($url)
			->seePageIs($url)
			->within('.body-content', function() use($result, $query) {
				$this->see($result)
					->seeElement('#search-bar input', ['value' => $query]);
			});
	}

	/**
	 * Function to provide search data for the tests.
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

	/**
	 * Function to set up the test environment for each test function.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->User = factory(User::class)->create();
	}

	/**
	 * Function to tear down the test environment for each test function.
	 *
	 * @return void
	 */
	public function tearDown() {
		User::destroy($this->User->id);
		$this->User = null;
		parent::tearDown();
	}
}
