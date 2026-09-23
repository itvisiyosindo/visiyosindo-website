<?php

namespace Database\Factories;

use App\Models\ProductCategoryContent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductCategoryContentFactory extends Factory
{
    protected $model = ProductCategoryContent::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
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
