<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Course Tag Factory
|--------------------------------------------------------------------------
|
| This factory will create new model instances for 
| testing / seeding your application's database.
|
*/

$factory->define(App\Models\CourseTag::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'name' => $faker->word,
        'description' => $faker->sentence
    ];
});
