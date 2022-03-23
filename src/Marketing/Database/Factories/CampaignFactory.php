<?php

namespace Octo\Marketing\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Models\Campaign;
use Octo\Marketing\Models\Contact;

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
            'message' => $this->faker->words(10, true),
            'start_at' => $this->faker->dateTime(),
            'end_at' => $this->faker->dateTime(),
            'properties' => [
                'channels' => ['email', 'sms'],
            ],
        ];
    }

    /**
    * Configure the model factory.
    *
    * @return $this
    */
    public function configure()
    {
        return $this->afterCreating(function (Campaign $campaign) {
            $campaign->contacts()->sync(
                Contact::inRandomOrder()->limit(rand(10, 49))->pluck('id')->toArray()
            );
        });
    }
}
