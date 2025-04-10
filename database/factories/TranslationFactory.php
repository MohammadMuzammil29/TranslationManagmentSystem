<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => 'key_' . fake()->uuid . '_' . fake()->randomNumber(6, true),
            'translations' => json_encode([
                'en' =>  fake()->sentence,
                'fr' =>  fake()->sentence,
                'es' =>  fake()->sentence,
                'de' =>  fake()->sentence
            ]),
            'tags' => json_encode(['mobile', 'web', 'desktop']),
        ];
    }
}

