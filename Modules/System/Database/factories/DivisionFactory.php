<?php
namespace Modules\System\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\System\Entities\Office\SYS_Division;
use Modules\System\Entities\Office\SYS_Office;

class DivisionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SYS_Division::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Office of the '.$this->faker->jobTitle,
            'alias' => null,
            'properties' => null,
            'office_id' => SYS_Office::factory()
        ];
    }
}

