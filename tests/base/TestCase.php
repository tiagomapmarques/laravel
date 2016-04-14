<?php

use Illuminate\Support\Facades\Artisan;

/**
 * Base class for test cases
 */
abstract class TestCase extends Illuminate\Foundation\Testing\TestCase {
	/**
	 * The base URL to use while testing the application.
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://localhost';

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication() {
		putenv('DB_CONNECTION=testing');

		$app = require __DIR__.'/../../bootstrap/app.php';

		$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

		return $app;
	}

	/**
	 * Function to set up the test environment for each test function.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		// create a minimalistic database
		Artisan::call('migrate');
		Artisan::call('db:seed');
	}

	/**
	 * Function to tear down the test environment after each test function.
	 *
	 * @return void
	 */
	public function tearDown() {
		// destroy all data and migrations from the database
		Artisan::call('migrate:reset');
		parent::tearDown();
	}
}
