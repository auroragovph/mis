<?php
namespace Modules\System\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\System\Entities\Office\SYS_Office;

class OfficeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SYS_Office::class;

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
            'properties' => null
        ];
    }
}

