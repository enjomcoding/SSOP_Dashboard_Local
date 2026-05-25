<?php

namespace Database\Factories;

use App\Models\RawMaterialLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RawMaterialLog>
 */
class RawMaterialLogFactory extends Factory
{
    protected $model = RawMaterialLog::class;

    public function definition(): array
    {
        $receivingDate = fake()->dateTimeBetween('-60 days', 'now');

        return [
            'agreed_scheduled_date' => fake()->optional(0.6)->date(),
            'receiving_date' => $receivingDate->format('Y-m-d'),
            'time_received' => fake()->time('H:i:s'),
            'delivery_vehicle_id' => fake()->optional(0.5)->regexify('TRK-[0-9]{3}'),
            'raw_material' => fake()->randomElement([
                'Chicken Breast',
                'Milk Powder',
                'Wheat Flour',
                'Vegetable Oil',
                'Sugar',
                'Salt',
            ]),
            'packaging_condition' => fake()->randomElement(['GOOD', 'DAMAGED']),
            'moisture_content_or_expiry' => fake()->optional(0.5)->randomElement([
                '12% moisture',
                'Exp ' . fake()->date('Y-m'),
                null,
            ]),
            'within_specs' => fake()->boolean(85),
            'quantity' => fake()->randomFloat(2, 50, 2000),
            'status' => fake()->randomElement(['ACCEPTED', 'REJECTED']),
            'created_at' => fake()->dateTimeBetween('-60 days', 'now'),
        ];
    }
}
