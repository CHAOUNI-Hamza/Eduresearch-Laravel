<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctorant>
 */
class DoctorantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'CIN' => $this->faker->unique()->bothify('???######'), // CIN unique
            'APOGEE' => $this->faker->unique()->numerify('######'), // APOGEE unique
            'NOM' => $this->faker->lastName,
            'PRENOM' => $this->faker->firstName,
            'date_inscription' => $this->faker->date(),
            'nationalite' => 'marocaine', // Valeur par défaut
            'date_soutenance' => $this->faker->optional()->date(), // Peut être nul
            'sujet_these' => $this->faker->sentence(),
            'user_id' => User::factory(), // Créer un utilisateur associé
        ];
    }
}
