<?php

namespace Database\Factories;

use App\Models\Arsip;
use App\Models\Program;
use App\Models\JenisArsip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Arsip>
 */
class ArsipFactory extends Factory
{
    protected $model = Arsip::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file' => $this->faker->image('public/file/arsip', 640, 480, null, false), // generates a placeholder image
            'programs_id' => Program::factory(),
            'jenisarsips_id' => JenisArsip::factory(),
        ];
    }
}
