<?php

namespace Database\Factories;

use App\Models\Finance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinanceFactory extends Factory
{
    protected $model = Finance::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['income', 'expense']);
        $quantity = $type === 'expense' ? $this->faker->numberBetween(1, 10) : null;
        $unitPrice = $type === 'expense' ? $this->faker->numberBetween(5000, 100000) : null;

        return [
            'date' => $this->faker->date(),
            'type' => $type,
            'category' => $this->faker->randomElement([
                'iuran bulanan',
                'donasi',
                'pengeluaran acara',
                'pembelian perlengkapan',
                'sumbangan warga',
            ]),
            'item_name' => $type === 'expense' ? $this->faker->word() : null,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $type === 'expense' ? $quantity * $unitPrice : $this->faker->numberBetween(10000, 100000),
            'description' => $this->faker->optional()->sentence(),
            'created_by' => User::factory(),
        ];
    }
}
