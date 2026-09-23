<?php

namespace Database\Factories;

use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsPostFactory extends Factory
{
    protected $model = NewsPost::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(5, true),
            'excerpt' => $this->faker->paragraph(),
            'author_id' => User::factory(),
            'status' => $this->faker->randomElement(['draft', 'published', 'scheduled']),
            'published_at' => $this->faker->dateTime(),
            'is_featured' => false,
            'featured_image' => $this->faker->imageUrl(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
