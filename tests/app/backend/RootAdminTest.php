<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Root admin test class
 */
class RootAdminTest extends AdminTestCase {
	/**
	 * Test the reponse of the admin page.
	 *
	 * @return void
	 */
	public function testResponse() {
		// test admin page 200 response code
		$this->visit('/')
			->assertResponseOk();
	}

	/**
	 * Test main content of the admin page.
	 *
	 * @return void
	 */
	public function testContent() {
		// test admin page's content
		$this->visit('/')->within('.main-header', function() {
			$this->see('Lurk Admin')
				->see('Home')
				->see('Logout');
		});

		// test root page's home redirect
		$this->visit('/')
			->click('Home')
			->see('Laravel Up and Running Kit');
	}

	/**
	 * Test admin side bar.
	 *
	 * @return void
	 */
	public function testSideBar() {
		// test admin page's content
		$this->visit('/')->within('.main-sidebar', function() {
			$this->see('Dashboard')
				->see('Users')
				->see('Roles');
		});
	}

	/**
	 * Test admin side bar.
	 *
	 * @return void
	 */
	public function testDefaultContent() {
		// test admin page's default content
		$this->visit('/')->within('.content-wrapper', function() {
			$this->see('Dashboard');
		});
	}
}
