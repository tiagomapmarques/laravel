<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;

/**
 * Users admin page test class
 */
class UsersAdminTest extends AdminTestCase {
	/**
	 * User id already created in the database.
	 *
	 * @var integer|null
	 */
	protected $user_id = null;

	/**
	 * Test the reponse of the Users page.
	 *
	 * @return void
	 */
	public function testResponse() {
		// test Users page 200 response code
		$this->visit('/users')
			->assertResponseOk();
	}

	/**
	 * Test main content of the Users page.
	 *
	 * @return void
	 */
	public function testContent() {
		// test dashboard page's content
		$this->visit('/users')->within('.content-wrapper', function() {
			$Users = User::all()->take(15);
			$this->see('Users');
			foreach($Users as $User) {
				$tmp = str_split($User->hash, 32);
				$this->see($User->name)
					->see($tmp[0])
					->see($tmp[1])
					->see($User->email)
					->see($User->image);
			}
		});
	}

	/**
	 * Test the creation of a User.
	 * TODO: create user with image as well
	 *
	 * @return void
	 */
	public function testCreateUser() {
		$User = factory(User::class)->make();

		// test creation
		$this->visit('/users')->within('.content-wrapper', function() {
			$this->click('New');
		});
		$this->type($User->name, 'name')
			->type($User->email, 'email')
			->press('Save');

		// check the user was created
		$this->seeInDatabase('users', [
			'name' => $User->name,
			'email' => $User->email,
			'image' => ''
		]);

		User::destroy($User->id);
	}

	/**
	 * Test the update process of a User.
	 * TODO: update image as well
	 *
	 * @return void
	 */
	public function testUpdateUser() {
		$User = factory(User::class)->create();
		$User2 = factory(User::class)->make();

		// test the update process
		$this->visit('/users/'.$User->id.'/edit')
			->type($User2->name, 'name')
			->type($User2->email, 'email')
			->press('Save');

		// check the user was created
		$this->seeInDatabase('users', [
			'name' => $User2->name,
			'email' => $User2->email,
			'image' => ''
		]);

		User::destroy($User->id);
	}

	/**
	 * Test the deletion of a User.
	 *
	 * @return void
	 */
	public function testDeleteUser() {
		$User = factory(User::class)->create();

		// test the delete process
		// TODO: perform the actual deletion

		// check the user was created
		// $this->dontSeeInDatabase('users', [
		// 	'email' => $User->email,
		// ]);

		User::destroy($User->id);
	}

	/**
	 * Function to set up the test environment for each test function.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->user_id = factory(User::class)->create()->id;
	}

	/**
	 * Function to tear down the test environment for each test function.
	 *
	 * @return void
	 */
	public function tearDown() {
		User::destroy($this->user_id);
		$this->user_id = null;
		parent::tearDown();
	}
}
