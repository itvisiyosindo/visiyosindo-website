<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'logo_path' => $this->faker->imageUrl(),
            'website_url' => $this->faker->url(),
            'description' => $this->faker->sentence(),
            'display_order' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
