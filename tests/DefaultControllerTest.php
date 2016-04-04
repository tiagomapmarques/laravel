<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Faker\Factory as Faker;

class DefaultControllerTest extends TestCase {
	/**
	 * Test the reponse of the home page
	 *
	 * @return void
	 */
	public function testResponse() {
		$this->visit('/')
			->assertResponseOk();
	}

	/**
	 * Test main content of the home page.
	 * TODO: make sure "Home" exists and is the "active" button on nav
	 *
	 * @return void
	 */
	public function testContent() {
		$this->visit('/')
			->see('Laravel Up and Running Kit');

		$this->visit('/')
			->see('li class="active"')
			->click('Home')
			->seePageIs('/');
	}
}
