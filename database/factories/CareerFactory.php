<?php

namespace Database\Factories;

use App\Models\Career;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CareerFactory extends Factory
{
    protected $model = Career::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraphs(3, true),
            'requirements' => json_encode($this->faker->words(5)),
            'salary_range' => 'Rp ' . $this->faker->numberBetween(10, 50) . ',000,000 - Rp ' . $this->faker->numberBetween(50, 100) . ',000,000',
            'position_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'freelance']),
            'location' => $this->faker->city(),
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
