<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $filePath=public_path("storage/images") ;
    if(!File::exists($filePath)){
        File::makeDirectory($filePath);
    }
    return [
        'title' => $faker->name,
        'users_id' => 1,
        'created_at' => now(),
        'body' => $faker->text,
        'image' => $faker->imageUrl(640,480),
    ];
    
});