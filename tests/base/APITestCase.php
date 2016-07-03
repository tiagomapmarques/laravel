<?php

use App\Models\Administrator;
use App\Models\User;

/**
 * Base class for admin tests
 */
abstract class APITestCase extends TestCase {
	/**
	 * The admin prefix for the application.
	 *
	 * @var string
	 */
	protected $apiPrefix = 'api';

	/**
	 * Administrator created in the database to be impersonated.
	 *
	 * @var \App\Models\User|null
	 */
	protected $Admin = null;

	/**
	 * User created in the database to be impersonated.
	 *
	 * @var \App\Models\User|null
	 */
	protected $User = null;

	/**
	 * User/Admin password.
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
		$this->baseUrl .= DS.$this->apiPrefix;
		return parent::createApplication();
	}

	/**
	 * Makes the test case login as a fake Administrator.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function actAsAdmin() {
		$this->actingAs($this->Admin);
	}

	/**
	 * Makes the test case login as a fake User.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function actAsUser() {
		$this->actingAs($this->User);
	}

	/**
	 * Function to set up the test environment for each test function.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		// create an Administrator and User
		$this->password = Generate::string();
		$this->Admin = factory(Administrator::class)->create([
			'password' => bcrypt($this->password)
		]);
		$this->User = factory(User::class)->create([
			'password' => bcrypt($this->password)
		]);
	}

	/**
	 * Function to tear down the test environment after each test function.
	 *
	 * @return void
	 */
	public function tearDown() {
		// destroy the Administrator and User
		Administrator::destroy($this->Admin->id);
		$this->Admin = null;
		User::destroy($this->User->id);
		$this->User = null;
		$this->password = null;
		parent::tearDown();
	}
}
