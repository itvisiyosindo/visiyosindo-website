<?php

namespace Database\Factories;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateFactory extends Factory
{
    protected $model = Certificate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'certificate_image_path' => 'certificates/' . $this->faker->uuid() . '.jpg',
            'description' => $this->faker->paragraph(),
        ];
    }
}
