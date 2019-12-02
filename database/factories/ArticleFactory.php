<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'cid' => mt_rand(2,5),
        'title'=>$faker->sentence(10, true),
        'des'=>$faker->paragraph(3, true),
        'pic'=>'/uploads/article/uKMIYkUiWmANHqXto71DBWFg5XIN19f6BrJ0M96u.png',
        'body'=>$faker->realText(),
        'create_time'=>$faker->unixTime
    ];
});
