<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'content' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(3, 5),
            'avatar_path' => null,
            'page_key' => 'home',
            'is_active' => true,
            'display_order' => $this->faker->numberBetween(0, 100),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
