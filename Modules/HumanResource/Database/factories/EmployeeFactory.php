<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(Modules\HumanResource\Entities\HR_Employee::class, function (Faker $faker) {
    return [
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'mname' => $faker->lastName,
        'gender' => $faker->numberBetween(1, 3),
        'address' => $faker->address,
        'birthday' => $faker->date,
        'civil_status' => $faker->randomElement($array = array('single', 'married', 'separated', 'widowed', 'union')),
        'phone_number' => $faker->phoneNumber,
        'position' => $faker->jobTitle,
        'division_id' => $faker->randomDigit,
        'employment_type' => $faker->numberBetween(1, 3),
        'employment_status' => $faker->boolean,
        'id_no' => $faker->randomNumber,
        'liaison' => $faker->boolean
    ];
});
