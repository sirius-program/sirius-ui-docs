<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DemoInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DemoInvoice>
 */
class DemoInvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number'        => 'INV-' . fake()->unique()->numberBetween(1000, 9999),
            'customer'      => fake()->company(),
            'status'        => 'pending',
            'amount'        => 12000,
            'workspace'     => 'design',
            'internal_note' => 'Private billing note',
        ];
    }
}
