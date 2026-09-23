<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    protected $model = Partner::class;

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
