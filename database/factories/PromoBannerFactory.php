<?php

namespace Database\Factories;

use App\Models\PromoBanner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromoBannerFactory extends Factory
{
    protected $model = PromoBanner::class;

    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'button_text' => $this->faker->word(),
            'image_path' => 'promo-banners/' . $this->faker->uuid() . '.jpg',
            'link_url' => $this->faker->url(),
            'display_order' => $this->faker->numberBetween(1, 10),
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
