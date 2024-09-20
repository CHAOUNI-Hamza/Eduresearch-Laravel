<?php

namespace Database\Factories;

use App\Models\Livre;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livre>
 */
class LivreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Livre::class;
    
    public function definition()
    {
        return [
            'titre' => $this->faker->sentence,
            'isbn' => $this->faker->isbn13,
            'depot_legal' => $this->faker->unique()->word,
            'issn' => $this->faker->optional()->isbn10,
            'annee' => $this->faker->year,
            'slug' => Str::slug($this->faker->unique()->word),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
