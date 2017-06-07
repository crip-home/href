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
$i = 0;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'tag' => $faker->word
    ];
});

$factory->define(App\Href::class, function (Faker\Generator $faker) use (&$i) {
    static $userId;

    return [
        'parent_id' => 0,
        'user_id' => $userId ?: $userId = 1,
        'date_added' => $faker->dateTimeInInterval('-1 year', '-1 day'),
        'index' => ++$i,
        'visible' => $faker->numberBetween(0, 1),
        'title' => $faker->title,
        'url' => $faker->url,
    ];
});
