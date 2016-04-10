<?php

use Illuminate\Database\Seeder;

use App\Role;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// truncate all the tables
		DB::table('roles')->truncate();
		DB::table('users')->truncate();
		DB::table('password_resets')->truncate();

		// create mandatory Roles (admin + user)
		$Admin_role = new Role();
		$Admin_role->name = Config::get('auth.admin_role_prefix');
		$Admin_role->class = 'Administrator';
		$Admin_role->save();
		$User_role = new Role();
		$User_role->name = 'user';
		$User_role->class = 'User';
		$User_role->save();

		// create an initial administrator
		$admin_email = 'admin@example.com';
		$Admin = factory(App\User::class, 'admin')->create([
			'name' => 'Administrator',
			'email' => $admin_email,
			'password' => bcrypt($admin_email),
		]);
	}
}
