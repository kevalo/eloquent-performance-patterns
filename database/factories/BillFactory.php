<?php

namespace Database\Factories;

use App\Enums\BillStatus;
use App\Models\Bill;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bill>
 */
class BillFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => fake()->text(10000),
            'payment' => fake()->numberBetween(20000, 600000),
            'company_id' => Company::factory(),
            'status' => collect(BillStatus::toArray())->random(),
        ];
    }
}
