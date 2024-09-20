<?php

namespace Database\Factories;

use App\Models\Equipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipe>
 */
class EquipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Equipe::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->word,
            'slug' => Str::slug($this->faker->unique()->word),
            'laboratoire_id' => \App\Models\Laboratoire::factory(),
        ];
    }
}
