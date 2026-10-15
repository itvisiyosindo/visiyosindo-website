<?php

namespace Database\Factories;

use App\Models\HomeIntroduction;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeIntroductionFactory extends Factory
{
    protected $model = HomeIntroduction::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'image_url' => $this->faker->imageUrl(),
            'button_text' => $this->faker->word(),
            'button_url' => $this->faker->url(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
