<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(Modules\HumanResource\Entities\HR_Employee::class, function (Faker $faker) {
    return [
        'division_id' => $faker->numberBetween(1, 25),
        'position_id' => $faker->numberBetween(1, 25),
        
        'name' => array(
            'fname' => $faker->firstName,
            'mname' => $faker->lastName,
            'lname' => $faker->lastName,
        ),
        'info' => array(
            'gender' => $faker->randomElement($array = array (1, 2)),
            'address' => $faker->address,
            'birthday' => $faker->date(),
            'civilStatus' => $faker->randomElement($array = array (1, 2, 3, 4)),
            'phoneNumber' => $faker->phoneNumber
        ),
        'employment' => array(
            'type' => $faker->numberBetween(1, 3),
            'status' => $faker->numberBetween(1, 2),
            'leave' => [
                'vacation' => $faker->numberBetween(1, 20),
                'sick' => $faker->numberBetween(1, 20)
            ]
        ),
        'card' => $faker->randomNumber,
        'liaison' => $faker->boolean
    ];
});
