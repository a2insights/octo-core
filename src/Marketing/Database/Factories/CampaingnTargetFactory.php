<?php

namespace Octo\Marketing\Database\Factories;

use App\CampaingnTarget;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaingnTargetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CampaingnTarget::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->word,
            'sended_at' => $this->faker->dateTime(),
            'data' =>  [],
            'deleted_at' => $this->faker->word,
        ];
    }
}
