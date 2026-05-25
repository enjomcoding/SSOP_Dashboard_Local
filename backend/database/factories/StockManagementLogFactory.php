<?php

namespace Database\Factories;

use App\Models\StockManagementLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockManagementLog>
 */
class StockManagementLogFactory extends Factory
{
    protected $model = StockManagementLog::class;

    public function definition(): array
    {
        $needsAttention = fake()->boolean(15);

        return [
            'warehouse_location' => fake()->randomElement([
                'Warehouse A - Rack 1',
                'Warehouse A - Rack 3',
                'Warehouse B - Cold Room',
                'Warehouse C - Dry Storage',
            ]),
            'log_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'log_time' => fake()->time('H:i:s'),
            'batch_lot_no' => 'PB-' . fake()->year() . '-' . fake()->numerify('###'),
            'quantity_in_stock' => fake()->randomFloat(2, 100, 2500),
            'expiry_date' => fake()->optional(0.9)->dateTimeBetween('now', '+1 year')?->format('Y-m-d'),
            'storage_condition' => $needsAttention ? 'NEEDS ATTENTION' : 'GOODS',
            'fifo_fefo_followed' => $needsAttention ? fake()->boolean(40) : fake()->boolean(90),
            'corrective_action' => $needsAttention ? fake()->sentence() : fake()->optional(0.1)->sentence(),
            'created_at' => fake()->dateTimeBetween('-60 days', 'now'),
        ];
    }
}
