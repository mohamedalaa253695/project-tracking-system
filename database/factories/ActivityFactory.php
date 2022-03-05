<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use App\Project;
use App\User;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        // 'user_id'=> factory(User::class)->create(),
        // 'project_id'=> factory(Project::class)->create(),
        // 'subject_type'=> $faker->title(),
        // 'subject_id'=>null,
        // 'description' => $
    ];
});
