<?php

namespace Database\Factories;

use App\Models\KontenProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KontenProgram>
 */
class KontenProgramFactory extends Factory
{
    protected $model = KontenProgram::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kontenprogram' => $this->faker->sentence,
            'foto' => $this->faker->image('public/file/kontenprogram', 640, 480, null, false), // generates a placeholder image
        ];
    }
}
