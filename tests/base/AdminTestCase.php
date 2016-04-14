<?php

use App\Models\User;
use App\Models\Role;

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
	 * User with admin Role already created in the database.
	 *
	 * @var \App\Models\User|null
	 */
	protected $User = null;

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
		$Role = Role::where('name', 'admin')->first();
		$this->password = 'password';
		$this->User = factory(User::class)->create([
			'password' => bcrypt($this->password),
			'role_id' => $Role->id
		]);
		$this->actingAs($this->User);
	}

	/**
	 * Function to tear down the test environment after each test function.
	 *
	 * @return void
	 */
	public function tearDown() {
		// destroy the administrator
		User::destroy($this->User->id);
		$this->User = null;
		$this->password = null;
		parent::tearDown();
	}
}
