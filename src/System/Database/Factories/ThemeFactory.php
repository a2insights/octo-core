<?php

namespace Octo\System\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Octo\System\Models\Theme;

class ThemeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Theme::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'title' => $this->faker->name,
            'description' => $this->faker->sentence,
            'author' => $this->faker->name,
            'license' => $this->faker->word,
            'active' => $this->faker->boolean,
            'private' => $this->faker->boolean,
            'installed' => $this->faker->boolean,
            'token' => $this->faker->word,
            'secret' => $this->faker->word,
            'version' => $this->faker->randomNumber(2),
            'thumbnail' => $this->faker->imageUrl(),
            'repository_url' => $this->faker->url,
            'repository_url' => $this->faker->url,
            'packagist_url' => $this->faker->url,
        ];
    }
}
