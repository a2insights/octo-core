<?php

namespace Octo\Marketing\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Models\Campaign;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => CampaignStatus::DRAFT(),
            'name' => $this->faker->word(2, true),
            'description' => $this->faker->words(3, true),
            'message' => $this->faker->words(10, true),
            'start_at' => $this->faker->dateTime(),
            'end_at' => $this->faker->dateTime(),
            'recurrent' => $this->faker->boolean,
            'properties' => [],
        ];
    }
}
