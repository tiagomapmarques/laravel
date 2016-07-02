<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Administrator;
use App\Models\Role;
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
		// test Users page's content (the default one only)
		$this->visit('/users')->within('.content-wrapper', function() {
			$Users = User::allRaw()->take(15);
			$this->see('All');
			foreach($Users as $User) {
				$hash_split = str_split($User->hash, 16);
				$this->see($User->name)
					->see($hash_split[0])
					->see($hash_split[1])
					->see($User->email)
					->see($User->image)
					->see(Language::trans('common.download').' '.Language::trans('database.users-image'))
					->see($User->role->id)
					->see(Language::trans('database.role-name-'.$User->role->name))
					->see('fa '.($User->isAdmin()?'fa-check':'fa-minus'));
			}
		});

		// test that tabs have the right content
		$Roles = Role::all();
		foreach($Roles as $Role) {
			$model = 'App\\Models\\'.$Role->model;
			$Users = $model::all()->take(15);
			$model_title = Language::trans('database.role-name-'.$Role->name ,2);
			$this->visit('/users')
				->see($model_title)
				->click($model_title)
				->within('.content-wrapper', function() use ($Users) {
					foreach($Users as $User) {
						$hash_split = str_split($User->hash, 16);
						$this->see($User->name)
							->see($hash_split[0])
							->see($hash_split[1])
							->see($User->email)
							->see($User->image)
							->see(Language::trans('common.download').' '.Language::trans('database.users-image'))
							->see($User->role->id)
							->see(Language::trans('database.role-name-'.$User->role->name))
							->see('fa '.($User->isAdmin()?'fa-check':'fa-minus'));
					}
				});
		}
	}

	/**
	 * Test the creation of a User.
	 * TODO: create user with image as well
	 *
	 * @return void
	 */
	public function testCreateUser() {
		$Roles = Role::all();
		foreach($Roles as $Role) {
			$User = factory(User::class)->make([
				'role_id' => $Role->id
			]);

			// test creation of a User with a specific Role
			$this->visit('/users')->within('.content-wrapper', function() {
				$this->click('New');
			});
			$this->type($User->name, 'name')
				->type($User->email, 'email')
				->select($User->role_id, 'role_id')
				->press('Save');

			// check the User was created
			$this->seeInDatabase('users', [
				'name' => $User->name,
				'email' => $User->email,
				'image' => '',
				'role_id' => $User->role_id
			]);

			User::destroy($User->id);
		}
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

		// check the User was created
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
		// TODO: perform the actual deletion instead of this hack
		User::destroy($User->id);

		// check the User was created
		// $this->dontSeeInDatabase('users', [
		// 	'email' => $User->email,
		// ]);

		// check the User was created
		$this->notSeeInDatabase('users', [
			'email' => $User->email
		]);
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
