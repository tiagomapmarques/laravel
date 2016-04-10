<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Faker\Factory as Faker;

use App\Role;

class AuthControllerTest extends TestCase {

	use DatabaseTransactions;

	/**
	 * Test the login and logout screens.
	 *
	 * @return void
	 */
	public function testLoginLogout() {
		// test login page 200 response code
		$this->visit('/login')
			->assertResponseOk();

		// test logout page 200 response code
		$this->visit('/logout')
			->assertResponseOk();

		// test a regular user's login
		$this->visit('/')
			->click('#login-button')
			->seePageIs('/login')
			->type('user@example.com', 'email')
			->type('user4user', 'password')
			->press('Login')
			->seePageIs('/')
			->dontSee('Login')
			->see('Logout');

		// test the logout
		$this->visit('/')
			->click('#logout-button')
			->seePageIs('/')
			->dontSee('Logout')
			->see('Login');
	}

	/**
	 * Test the admin login and logout screens.
	 *
	 * @return void
	 */
	public function testAdminLoginLogout() {
		// test admin login
		$this->visit('/')
			->click('#login-button')
			->seePageIs('/login')
			->type('admin@example.com', 'email')
			->type('admin4admin', 'password')
			->press('Login')
			->seePageIs('/')
			->dontSee('Login')
			->see('Logout');

		// test that the admin can access an admin only area
		$this->visit('/admin')
			->see('Lurk Admin');

		// test admin logout
		$this->visit('/')
			->click('#logout-button')
			->seePageIs('/')
			->dontSee('Logout')
			->see('Login');
	}

	/**
	 * Test the password reset screen.
	 * TODO: also test the sending of the email.
	 *
	 * @return void
	 */
	public function testPasswordReset() {
		$this->visit('/password/reset')
			->assertResponseOk();

		$this->visit('/')
			->click('#login-button')
			->click('#forgot-password-button')
			->seePageIs('/password/reset');
			// ->type('user@example.com', 'email')
			// ->click('Send Password Reset Link')
			// ->seePageIs('/');
	}

	/**
	 * Test the register screen.
	 *
	 * @return void
	 */
	public function testRegister() {
		// create random name, email and password
		$faker = Faker::create();
		$name = $faker->name;
		$email = $faker->safeemail;
		$password = Helper::generateHash();

		// test register page 200 response code
		$this->visit('/register')
			->assertResponseOk();

		// test the registration process
		$this->visit('/')
			->click('#register-button')
			->seePageIs('/register')
			->type($name, 'name')
			->type($email, 'email')
			->type($password, 'password')
			->type($password, 'password_confirmation')
			->press('Register')
			->seePageIs('/')
			->dontSee('Login')
			->see('Logout');

		// test that the user was created in the database
		// and that it is not an admin
		$Role = Role::where('name', 'user')->first();
		$this->seeInDatabase('users', [
			'name' => $name,
			'email' => $email,
			'role_id' => $Role->id
		]);
	}
}
