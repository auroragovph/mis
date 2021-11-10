<?php
namespace Modules\HumanResource\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HumanResource\Entities\HR_Plantilla;
use Modules\HumanResource\Entities\HR_SalaryGrade;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HR_Plantilla::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position' => $this->faker->jobTitle,
            'salary_grade_id' => HR_SalaryGrade::factory(),
            'properties' => null
        ];
    }
}

