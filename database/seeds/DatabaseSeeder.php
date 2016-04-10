<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Role;
use App\User;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker::create();

		// truncate all the tables
		DB::table('roles')->truncate();
		DB::table('users')->truncate();
		DB::table('password_resets')->truncate();

		// create roles
		$Admin_role = new Role();
		$Admin_role->name = Config::get('auth.admin_role_prefix');
		$Admin_role->class = 'Administrator';
		$Admin_role->save();
		$User_role = new Role();
		$User_role->name = 'user';
		$User_role->class = 'User';
		$User_role->save();

		// create admins
		$Admin1 = new User();
		$Admin1->name = $faker->name;
		$Admin1->email = 'admin@example.com';
		$Admin1->password = bcrypt('admin4admin');
		$Admin1->role()->associate($Admin_role);
		$Admin1->save();

		// create users
		$User1 = new User();
		$User1->name = $faker->name;
		$User1->email = 'user@example.com';
		$User1->password = bcrypt('user4user');
		$User1->save();
	}
}
