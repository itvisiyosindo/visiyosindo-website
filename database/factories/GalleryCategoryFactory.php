<?php

namespace Database\Factories;

use App\Models\GalleryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryCategoryFactory extends Factory
{
    protected $model = GalleryCategory::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
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
