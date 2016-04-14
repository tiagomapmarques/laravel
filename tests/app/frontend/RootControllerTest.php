<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * RootController test class
 */
class RootControllerTest extends TestCase {
	/**
	 * Test the reponse of the home page.
	 *
	 * @return void
	 */
	public function testResponse() {
		// test root page 200 response code
		$this->visit('/')
			->assertResponseOk();
	}

	/**
	 * Test main content of the home page.
	 *
	 * @return void
	 */
	public function testContent() {
		// test root page's content
		$this->visit('/')
			->see('Laravel Up and Running Kit')
			->see('Home')
			->see('Login')
			->see('Register');
	}
}
