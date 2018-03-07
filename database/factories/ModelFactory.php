<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
*/


//Users model factory
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $faker_email = $faker->unique()->safeEmail;

    return [
        'name' => $faker->firstName,
        'surnames' => $faker->lastName.' '.$faker->lastName,
        'email' => $faker_email,
        'nickname' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'api_key' => str_random(60),
        'role_id' => $faker->numberBetween(3, 5),
        'active' => 1,
    ];
});


//Clinics model factory
$factory->define(App\Clinic::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->company,
        'contact' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'nif' => $faker->unique()->swiftBicNumber,
        'address' => $faker->streetAddress,
        'locality' => $faker->city,
        'province' => $faker->state,
        'country' => $faker->country,
        'post_code' => $faker->postcode,
        'phone' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber,
        'percentage' => 50,
        'active' => 1,
    ];
});
