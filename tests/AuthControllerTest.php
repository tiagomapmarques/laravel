<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Faker\Factory as Faker;

class AuthControllerTest extends TestCase {

	use DatabaseTransactions;

	/**
	 * Test the login and logout screens.
	 *
	 * @return void
	 */
	public function testLoginLogout() {
		$this->visit('/login')
			->assertResponseOk();

		$this->visit('/logout')
			->assertResponseOk();

		$this->visit('/')
			->click('#login-button')
			->seePageIs('/login')
			->type('user@example.com', 'email')
			->type('user4user', 'password')
			->press('Login')
			->seePageIs('/')
			->dontSee('Login')
			->see('Logout');

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
		$faker = Faker::create();

		$name = $faker->name;
		$email = $faker->safeemail;
		$password = Helper::generateHash();

		$this->visit('/register')
			->assertResponseOk();

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

		$this->seeInDatabase('users', [
			'name' => $name,
			'email' => $email
		]);
	}
}
