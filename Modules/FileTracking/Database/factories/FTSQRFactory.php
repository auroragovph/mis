<?php 

namespace Modules\FileTracking\Database\factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\FileTracking\Entities\FTS_QR;

class FTSQRFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FTS_QR::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => false
        ];
    }
}