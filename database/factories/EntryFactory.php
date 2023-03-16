<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject' => \Illuminate\Support\Arr::random(['english', 'science', 'math']),
            'question' => fake()->sentence(5),
            'answer' => fake()->word(),
        ];
    }
}
