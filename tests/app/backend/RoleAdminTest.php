<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Role;

/**
 * Root admin test class
 */
class RoleAdminTest extends AdminTestCase {
	/**
	 * Test the reponse of the admin page.
	 *
	 * @return void
	 */
	public function testResponse() {
		// test admin page 200 response code
		$this->visit('/roles')
			->assertResponseOk();
	}

	/**
	 * Test main content of the admin page.
	 *
	 * @return void
	 */
	public function testContent() {
		// test admin page's content
		$this->visit('/roles')->within('.content-wrapper', function() {
			$this->see('Roles');
			$Roles = Role::all();
			foreach($Roles as $Role) {
				$this->see($Role->name)
					->see(Language::trans('database.role-name-'.$Role->name));
			}
		});
	}
}
