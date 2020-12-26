<?php
namespace Modules\HumanResource\Database\factories;

use Modules\HumanResource\Entities\HR_Plantilla;
use Modules\System\Entities\Office\SYS_Division;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\HumanResource\Entities\HR_Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = [
            'fname' => $this->faker->firstName,
            'mname' => $this->faker->lastName,
            'lname' => $this->faker->lastName,
            'sname' => $this->faker->suffix,
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
           'division_id' => SYS_Division::factory(),
           'position_id' => HR_Plantilla::factory(),
           'name' => json_encode($name),
           'info' => json_encode($info),
           'employment' => json_encode($employment),
           'card' => $this->faker->numerify('PGA-###'),
           'liaison' => $this->faker->randomElement($array = array (1, 0)),
           'properties' => null
        ];
    }
}

