<?php

namespace Database\Factories;

use App\Models\MapMarker;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapMarkerFactory extends Factory
{
    protected $model = MapMarker::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'address' => $this->faker->address(),
            'description' => $this->faker->paragraph(),
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
