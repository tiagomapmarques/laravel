<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Dashboard admin page test class
 */
class DashboardAdminTest extends AdminTestCase {
	/**
	 * Test the reponse of the dashboard page.
	 *
	 * @return void
	 */
	public function testResponse() {
		// test dashboard page 200 response code
		$this->visit('/')
			->assertResponseOk();
	}

	/**
	 * Test main content of the dashboard page.
	 *
	 * @return void
	 */
	public function testContent() {
		// test dashboard page's content
		$this->visit('/')->within('.content-wrapper', function() {
			$this->see('Dashboard')
				->see('This is the LURK Admin section.');
		});
	}
}
