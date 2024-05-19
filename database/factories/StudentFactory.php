<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nomeCursos = [
            'Engenharia de Software',
            'Ciência da Computação',
            'Sistemas de Informação',
            'Análise e Desenvolvimento de Sistemas',
            'Engenharia de Computação',
            'Tecnologia em Redes de Computadores',
            'Tecnologia em Sistemas para Internet',
            'Tecnologia em Banco de Dados',
        ];

        return [
            'name' => $this->faker->name,
            'course' => $this->faker->randomElement($nomeCursos),
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'created_at' => now(),
            'updated_at'=> now(),
        ];
    }
}
