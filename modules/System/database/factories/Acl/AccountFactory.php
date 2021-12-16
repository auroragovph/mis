<?php
namespace Modules\System\database\factories\Acl;

use Modules\System\core\Models\ACL\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'employee_id' => $this->faker->numberBetween(1, 100),
            'username' => $this->faker->userName(),
            'password' => '$2a$12$cQmWZ69yVi/YtWGBP0.aQeijYoHyogmLB6GgLXk39L0RjAZBj0OBK',
            'status' => true
        ];
    }
}

