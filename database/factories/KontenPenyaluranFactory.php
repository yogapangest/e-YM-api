<?php

namespace Database\Factories;

use App\Models\KontenPenyaluran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KontenPenyaluran>
 */
class KontenPenyaluranFactory extends Factory
{
    protected $model = KontenPenyaluran::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_penyaluran' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'foto' => $this->faker->image('public/file/kontenpenyaluran', 640, 480, null, false), // generates a placeholder image
        ];
    }
}
