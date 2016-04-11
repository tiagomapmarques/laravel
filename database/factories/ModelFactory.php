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
$factory->define(App\User::class, function (Faker\Generator $faker) use ($factory) {
	return [
		'name' => $faker->name,
		'email' => $faker->safeEmail,
		'password' => bcrypt(str_random(10)),
		'image' => '',
		'role_id' => App\Role::where('name', 'user')->first()->id,
		'remember_token' => str_random(10),
	];
});
$factory->defineAs(App\User::class, 'admin', function (Faker\Generator $faker) use ($factory) {
	$user = $factory->raw(App\User::class);
	$user['role_id'] = App\Role::where('name', 'admin')->first()->id;
	return $user;
});
