<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use App\Models\Role;

/**
 * UserController test class
 */
class UserControllerTest extends TestCase {
	/**
	 * User already created in the database.
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
	 * Test the User details are being shown in the home page.
	 *
	 * @return void
	 */
	public function testUserDetails() {
		// make new user and save it to the database
		$Role = Role::where('name', 'user')->first();

		// test home page redirect and 200 response code
		$this->visit('/home')
			->seePageIs('/login')
			->assertResponseOk();

		// check that User details are being displayed
		$this->visit('/home')
			->seePageIs('/login')
			->type($this->User->email, 'email')
			->type($this->password, 'password')
			->press('Login')
			->seePageIs('/home')
			->see($this->User->name)
			->see($this->User->email)
			->see($Role->class);
	}

	/**
	 * Test the User details update functionality.
	 *
	 * @return void
	 */
	public function testUserUpdate() {
		// make new User and save it to the database
		$upload_test_file = realpath(base_path().'/tests/files/upload_test.png');
		if(!file_exists($upload_test_file)) {
			$this->fail('Upload test file is missing!');
		}
		$old_image = $this->User->getImage();
		$new_name = Helper::generateRandomString();
		$Role = Role::where('name', 'user')->first();

		// navigate to and submit new User details
		$this->visit('/login')
			->type($this->User->email, 'email')
			->type($this->password, 'password')
			->press('Login')
			->seePageIs('/home')
			->see('/'.$old_image)
			->click('#user-update-button')
			->seePageIs('/user/update')
			->type($new_name, 'name')
			->attach($upload_test_file, 'image')
			->press('Save');

		// update our User object
		$this->User = User::find($this->User->id);

		// check the details have been updated
		$this->seeInDatabase('users', [
			'email' => $this->User->email,
			'name' => $new_name
		]);
		if($old_image===$this->User->getImage()) {
			$this->fail('Image was not updated!');
		}
	}

	/**
	 * Test the User password change.
	 *
	 * @return void
	 */
	public function testUserPassword() {
		// make new User and save it to the database
		$new_password = Helper::generateHash();

		// change the User password
		$this->visit('/login')
			->type($this->User->email, 'email')
			->type($this->password, 'password')
			->press('Login')
			->seePageIs('/home')
			->click('#user-update-button')
			->seePageIs('/user/update')
			->click('Change Password')
			->seePageIs('/user/password')
			->type($this->password, 'old_password')
			->type($new_password, 'password')
			->type($new_password, 'password_confirmation')
			->press('Change Password')
			->seePageIs('/home')
			->see('Your password was changed successfully!')
			->click('Logout')
			->seePageIs('/');

		// test a regular User's login with the new password
		// TODO: check the database instead of testing the login process
		$this->visit('/')
			->click('#login-button')
			->seePageIs('/login')
			->type($this->User->email, 'email')
			->type($new_password, 'password')
			->press('Login')
			->seePageIs('/home')
			->dontSee('Login')
			->dontSee('Admin')
			->see('Logout');
	}

	/**
	 * Function to set up the test environment for each test function.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->password = 'password';
		$this->User = factory(User::class)->create([
			'password' => bcrypt($this->password)
		]);
	}

	/**
	 * Function to tear down the test environment for each test function.
	 *
	 * @return void
	 */
	public function tearDown() {
		User::destroy($this->User->id);
		$this->password = null;
		$this->User = null;
		parent::tearDown();
	}
}
