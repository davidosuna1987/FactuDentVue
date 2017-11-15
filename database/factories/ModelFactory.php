<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

// Users model factory
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $faker_email = $faker->unique()->safeEmail;

    return [
        'name' => $faker->name,
        'email' => $faker_email,
        'email' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'api_key' => bcrypt($faker_email),
        'role_id' => $faker->numberBetween(3, 3),
        'active' => false,
    ];
});
