<?php

namespace Database\Factories;

use App\Models\CertificateCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CertificateCategoryFactory extends Factory
{
    protected $model = CertificateCategory::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'order' => $this->faker->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
