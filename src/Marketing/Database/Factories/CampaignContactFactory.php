<?php

namespace Octo\Marketing\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Models\CampaignContact;

class CampaignContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CampaignContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => CampaignStatus::DRAFT(),
            'notified_at' => $this->faker->dateTime(),
            'data' =>  [],
        ];
    }
}
