<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'username'=>$faker->userName,
        'truename'=>$faker->name,
        'password'=> Hash::make('1q2w3e'),
        'email'=>$faker->email,
        'phone'=>$faker->phoneNumber,
        'sex'=> ['先生','女士'][mt_rand(0,1)],
        'last_ip'=>'127.0.0.1',
        'create_time'=>time()
    ];
});
