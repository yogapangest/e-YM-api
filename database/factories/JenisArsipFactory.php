<?php

namespace Database\Factories;

use App\Models\JenisArsip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisArsip>
 */
class JenisArsipFactory extends Factory
{
    protected $model = JenisArsip::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_arsip' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
        ];
    }
}
