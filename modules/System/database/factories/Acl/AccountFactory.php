<?php
namespace Modules\System\database\factories\Acl;

use Modules\System\core\Models\ACL\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('password'),
            'status' => true
        ];
    }
}

