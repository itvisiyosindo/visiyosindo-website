<?php

namespace Database\Factories;

use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobVacancyFactory extends Factory
{
    protected $model = JobVacancy::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'department' => $this->faker->word(),
            'location' => $this->faker->city(),
            'type' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
            'experience' => $this->faker->numberBetween(1, 10) . ' years',
            'education' => $this->faker->randomElement(['SMA', 'Diploma', 'Bachelor', 'Master']),
            'salary_range' => 'Rp ' . $this->faker->numberBetween(10, 50) . 'M - Rp ' . $this->faker->numberBetween(50, 100) . 'M',
            'description' => $this->faker->paragraph(),
            'responsibilities' => $this->faker->sentences(3),
            'requirements' => $this->faker->words(5),
            'benefits' => $this->faker->words(5),
            'skills' => $this->faker->words(5),
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
