<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BuktiDonasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuktiDonasi>
 */
class BuktiDonasiFactory extends Factory
{
    protected $model = BuktiDonasi::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nominal' => $this->faker->randomFloat(2, 1000, 5000),
            'deskripsi' => $this->faker->paragraph,
            'file' => $this->faker->image('public/file/donasi', 640, 480, null, false), // generates a placeholder image
            'users_id' => User::factory(),
        ];
    }
}
