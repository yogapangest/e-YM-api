<?php

namespace Database\Factories;

use App\Models\Distribusi;
use App\Models\DistribusiBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DistribusiBarang>
 */
class DistribusiBarangFactory extends Factory
{
    protected $model = DistribusiBarang::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $volume = $this->faker->randomNumber();
        $harga_satuan = $this->faker->randomFloat(2, 500, 3000);

        return [
            'nama_barang' => $this->faker->sentence,
            'volume' => $volume,
            'satuan' => 'nota',
            'harga_satuan' => $harga_satuan,
            'jumlah' => $volume * $harga_satuan,
            'distribusis_id' => Distribusi::factory(),
        ];
    }
}
