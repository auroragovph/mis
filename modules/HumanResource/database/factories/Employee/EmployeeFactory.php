<?php
namespace Modules\HumanResource\database\factories\Employee;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HumanResource\core\Models\Employee\Employee;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = [
            'first' => $this->faker->firstName,
            'middle' => $this->faker->lastName,
            'last' => $this->faker->lastName,
            'suffix' => $this->faker->suffix,
            'title' => null
        ];

        $info = [
            'gender' => $this->faker->randomElement($array = array ('Male', 'Female')),
            'birthday' => $this->faker->date(),
            'address' => $this->faker->address,
            'civilStatus' => $this->faker->randomElement($array = array ('Single', 'Married')),
            'phoneNumber' => $this->faker->phoneNumber,
            'image' => null
        ];

        $employment = [
            'type' => $this->faker->randomElement($array = array ('Job Order', 'Casual', 'Permanent')),
            'status' => 'active',
            'leave' => [
                'vacation' => $this->faker->numberBetween(1, 100),
                'sick' => $this->faker->numberBetween(1, 100)
            ]
        ];

        return [
           'office_id'    => $this->faker->numberBetween(1, 20),
           'position_id'    => $this->faker->numberBetween(1, 2000),
           'name'           => $name,
           'info'           => $info,
           'employment'     => $employment,
           'card'           => $this->faker->numerify('PGA-###'),
           'liaison'        => $this->faker->randomElement($array = array (1, 0)),
           'properties'     => null
        ];
    }
}

