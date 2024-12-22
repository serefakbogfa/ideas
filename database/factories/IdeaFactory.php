<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IdeaFactory extends Factory
{
    protected $model = Idea::class;

    public function definition(): array
    {
        return [
            'content' => fake()->sentence(),
            'user_id' => User::factory(),
            'image' => null,
            'likes_count' => 0
        ];
    }
} 