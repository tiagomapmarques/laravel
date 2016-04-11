<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Role;

class AuthControllerTest extends TestCase {
	/**
	 * Test the register screen.
	 *
	 * @return void
	 */
	public function testRegister() {
		// just make new user and dont save it to the database
		$password = 'password';
		$User = factory(User::class)->make([
			'password' => bcrypt($password)
		]);

		// test register page 200 response code
		$this->visit('/register')
			->assertResponseOk();

		// test the registration process
		$this->visit('/')
			->click('#register-button')
			->seePageIs('/register')
			->type($User->name, 'name')
			->type($User->email, 'email')
			->type($password, 'password')
			->type($password, 'password_confirmation')
			->press('Register')
			->seePageIs('/home')
			->dontSee('Login')
			->see('Logout');

		// test that the user was created in the database
		// and that it is not an admin
		$role_id = Role::where('name', 'user')->first()->id;
		$this->seeInDatabase('users', [
			'name' => $User->name,
			'email' => $User->email,
			'role_id' => $role_id
		]);
	}

	/**
	 * Test the login and logout screens.
	 *
	 * @return void
	 */
	public function testLoginLogout() {
		// make new user and save it to the database
		$password = 'password';
		$User = factory(User::class)->create([
			'password' => bcrypt($password)
		]);

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
			->type($User->email, 'email')
			->type($password, 'password')
			->press('Login')
			->seePageIs('/home')
			->dontSee('Login')
			->dontSee('Admin')
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
		// get the random admin from the database
		$Admin = User::where('role_id', Role::where('name', 'admin')->first()->id)->first();

		// test admin login
		$this->visit('/')
			->click('#login-button')
			->seePageIs('/login')
			->type($Admin->email, 'email')
			->type($Admin->email, 'password')
			->press('Login')
			->seePageIs('/home')
			->dontSee('Login')
			->see('Admin')
			->see('Logout');

		// test that the admin can access an admin only area
		$this->visit('/admin')
			->see('Lurk Admin')
			->see('Home')
			->see('Logout');

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
}
