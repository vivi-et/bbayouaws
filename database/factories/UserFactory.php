<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\User;
use App\Post;
use App\Comment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});



$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->randomDigit(1,10)+1,
        'title' => $faker->sentence(1),
        'body' => $faker->sentence(5),
        'cover_image'=> 'noimage.jpg',
        'board_id' => $faker->randomDigit(1,5),

    ];
});


$factory->define(App\Comment::class, function (Faker $faker) {
    $count = Post::all()->count();
    $rand = random_int(1, $count);
    return [
        'post_id' => $faker->randomDigit($count),
        'body' => $faker->sentence(5)

    ];
});
