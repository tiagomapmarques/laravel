<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchControllerTest extends TestCase {
	/**
	 * Test the search functionality
	 * TODO: perform a search inside the page
	 *
	 * @dataProvider searchData
	 * @return void
	 */
	public function testSearch($query, $result) {
		// test search page 200 response code
		$this->visit('/search')
			->assertResponseOk();

		// create the search url
		$url = '/search'.(strlen($query)>0? '?q='.str_replace(' ', '+', $query) : '');

		// test if the search is performed correctly
		$this->visit($url)
			->seePageIs($url)
			->seeElement('#search-bar input', ['value' => $query])
			->see($result);
	}

	// function to provide data for the tests
	public function searchData() {
		return array(
			array('user', 'user@example.com'),
			array('user2', '0 results'),
			array('', '0 results'),
		);
	}
}
