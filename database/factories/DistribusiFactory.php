<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Distribusi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Distribusi>
 */
class DistribusiFactory extends Factory
{
    protected $model = Distribusi::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->date(),
            'tempat' => $this->faker->address(),
            'penerima_manfaat' => $this->faker->name(),
            'anggaran' => $this->faker->randomFloat(2, 1000, 5000),
            'pengeluaran' => $this->faker->randomFloat(2, 500, 3000),
            'file' => $this->faker->image('public/file/distribusi', 640, 480, null, false), // generates a placeholder image
            'programs_id' => Program::factory(),
        ];
    }
}
