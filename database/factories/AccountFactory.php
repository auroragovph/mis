<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HumanResource\Entities\HR_Employee;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => HR_Employee::factory()->create(),
            'username' => $this->faker->userName,
            'password' => bcrypt('password'),
            'status' => 1,
            'properties' => null
        ];
    }
}
