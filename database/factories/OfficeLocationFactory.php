<?php

namespace Database\Factories;

use App\Models\OfficeLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfficeLocationFactory extends Factory
{
    protected $model = OfficeLocation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
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
