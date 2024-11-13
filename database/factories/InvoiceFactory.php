<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InvoiceModel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = InvoiceModel::class;

    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name,
            'overall_amt' => $this->faker->randomFloat(2, 100, 10000),
            'payment_type' => $this->faker->randomElement(['Paid', 'Unpaid']),
            'created_at' => $this->faker->dateTimeThisYear,
            'updated_at' => $this->faker->dateTimeThisYear,       
         ];
    }
}