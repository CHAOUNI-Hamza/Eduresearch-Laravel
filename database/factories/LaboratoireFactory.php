<?php

namespace Database\Factories;

use App\Models\Laboratoire;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Laboratoire>
 */
class LaboratoireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Laboratoire::class;
    
    public function definition()
    {
        return [
            'nom' => $this->faker->company,
            'slug' => Str::slug($this->faker->unique()->company),
        ];
    }
}
