<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Article::class;
    
    public function definition()
    {
        return [
            'titre' => $this->faker->sentence,
            'revue' => $this->faker->word,
            'url' => $this->faker->url,
            'annee' => $this->faker->year,
            'slug' => Str::slug($this->faker->unique()->word),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
