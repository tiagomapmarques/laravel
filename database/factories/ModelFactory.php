<?php
/* --------------------------------------------------------------------------
 *  Model Factories
 * --------------------------------------------------------------------------
 *
 * Here you may define all of your model factories. Model factories give
 * you a convenient way to create models for testing and seeding your
 * database. Just tell the factory how a default model should look.
 *
 */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) use ($factory) {
	return [
		'name' => $faker->name,
		'email' => $faker->safeEmail,
		'password' => bcrypt(str_random(10)),
		'image' => '',
		'role_id' => App\Models\Role::allUser()[0]->id,
		'remember_token' => str_random(10),
	];
});
$factory->define(App\Models\Administrator::class, function (Faker\Generator $faker) use ($factory) {
	return [
		'name' => $faker->name,
		'email' => $faker->safeEmail,
		'password' => bcrypt(str_random(10)),
		'image' => '',
		'role_id' => App\Models\Role::allAdmin()[0]->id,
		'remember_token' => str_random(10),
	];
});
