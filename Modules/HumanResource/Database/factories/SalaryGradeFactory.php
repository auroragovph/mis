<?php
namespace Modules\HumanResource\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HumanResource\Entities\HR_SalaryGrade;

class SalaryGradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HR_SalaryGrade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'step1' => $this->faker->randomFloat(),
            'step2' => $this->faker->randomFloat(),
            'step3' => $this->faker->randomFloat(),
            'step4' => $this->faker->randomFloat(),
            'step5' => $this->faker->randomFloat(),
            'step6' => $this->faker->randomFloat(),
            'step7' => $this->faker->randomFloat(),
            'step8' => $this->faker->randomFloat()
        ];
    }
}

