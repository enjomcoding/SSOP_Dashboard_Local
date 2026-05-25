<?php

namespace Database\Factories;

use App\Models\DeliveryTruckLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeliveryTruckLog>
 */
class DeliveryTruckLogFactory extends Factory
{
    protected $model = DeliveryTruckLog::class;

    public function definition(): array
    {
        $pestActivity = fake()->boolean(15);

        return [
            'truck_plate_no' => strtoupper(fake()->bothify('???-####')),
            'driver_name' => fake()->name(),
            'inspection_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'inspection_time' => fake()->time('H:i:s'),
            'exterior_condition' => fake()->randomElement(['CLEAN', 'DIRTY']),
            'interior_condition' => fake()->randomElement(['CLEAN', 'DIRTY']),
            'odor' => fake()->randomElement(['NORMAL', 'UNUSUAL']),
            'pest_activity' => $pestActivity,
            'sanitized' => fake()->boolean(80),
            'maintenance_issues' => fake()->boolean(10),
            'corrective_action' => $pestActivity ? fake()->sentence() : fake()->optional(0.2)->sentence(),
            'created_at' => fake()->dateTimeBetween('-60 days', 'now'),
        ];
    }
}
