<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\User;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker::create();

		DB::table('users')->truncate();
		DB::table('password_resets')->truncate();

		$user1 = new User();
		$user1->name = $faker->name;
		$user1->email = 'user@example.com';
		$user1->password = bcrypt('user4user');
		$user1->save();
	}
}
