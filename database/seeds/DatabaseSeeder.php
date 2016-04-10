<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\User;
use App\Administrator;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker::create();

		// truncate all the tables
		DB::table('users')->truncate();
		DB::table('password_resets')->truncate();

		// create users
		$user1 = new User();
		$user1->name = $faker->name;
		$user1->email = 'user@example.com';
		$user1->password = bcrypt('user4user');
		$user1->save();

		// create admins
		$admin1 = new Administrator();
		$admin1->name = $faker->name;
		$admin1->username = 'admin';
		$admin1->email = 'admin@example.com';
		$admin1->password = bcrypt('admin4admin');
		$admin1->save();
	}
}
