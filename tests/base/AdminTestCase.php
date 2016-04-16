<?php

use App\Models\Administrator;

/**
 * Base class for admin tests
 */
abstract class AdminTestCase extends TestCase {
	/**
	 * The admin prefix for the application.
	 *
	 * @var string
	 */
	protected $adminPrefix = 'admin';

	/**
	 * Administrator created in the database to be impersonated.
	 *
	 * @var \App\Models\User|null
	 */
	protected $Admin = null;

	/**
	 * User password.
	 *
	 * @var string|null
	 */
	protected $password = null;

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication() {
		$this->baseUrl .= DIRECTORY_SEPARATOR.$this->adminPrefix;
		return parent::createApplication();
	}

	/**
	 * Function to set up the test environment for each test function.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		// create an administrator
		$this->password = 'password';
		$this->Admin = factory(Administrator::class)->create([
			'password' => bcrypt($this->password)
		]);
		$this->actingAs($this->Admin);
	}

	/**
	 * Function to tear down the test environment after each test function.
	 *
	 * @return void
	 */
	public function tearDown() {
		// destroy the administrator
		Administrator::destroy($this->Admin->id);
		$this->Admin = null;
		$this->password = null;
		parent::tearDown();
	}
}
