<?php

namespace Octo\Marketing\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Octo\Marketing\Models\Contact;

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
            'name' => $this->faker->name,
            'properties' => [],
            'email' => $this->faker->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'phone_number_is_whatsapp' => $this->faker->boolean,
            'birthday' => $this->faker->date,
            'gender' => $this->faker->word,
            'favorite' => $this->faker->boolean,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Contact $contact) {
            $contact->syncTagsWithType($this->faker->words(rand(0, 2)), 'contacts.tags');
        });
    }
}
