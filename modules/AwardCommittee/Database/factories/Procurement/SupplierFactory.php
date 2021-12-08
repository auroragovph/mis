<?php
namespace Modules\AwardCommittee\Database\factories\Procurement;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AwardCommittee\Entities\Procurement\Supplier;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'name'       => $this->faker->company(),
           'owner'      => $this->faker->name(),
           'address'    => $this->faker->address(),
           'tin'        => $this->faker->isbn10()
        ];
    }
}

