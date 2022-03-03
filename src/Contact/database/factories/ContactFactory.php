<?php

namespace Octo\Contact\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Octo\Contact\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'contact_type' => $this->faker->word,
            // 'contact_id' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->boolean,
            'name' => $this->faker->name,
            'properties' => '{}',
            'nickname' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'mobile_phone' => $this->faker->phoneNumber,
            'mobile_phone_is_whatsapp' => $this->faker->boolean,
            'birthday' => $this->faker->date,
            'gender' => $this->faker->word,
            'favorite' => $this->faker->boolean,
            'notificable' => $this->faker->boolean,
            'loggable' => $this->faker->boolean,
            // 'deleted_at' => $this->faker->word,
        ];
    }
}
