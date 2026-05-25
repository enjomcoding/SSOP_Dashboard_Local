<?php

namespace Database\Factories;

use App\Models\OilTemperatureLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OilTemperatureLog>
 */
class OilTemperatureLogFactory extends Factory
{
    protected $model = OilTemperatureLog::class;

    public function definition(): array
    {
        $temp = fake()->randomFloat(2, 160, 190);
        $outOfRange = $temp < 170 || $temp > 185;

        return [
            'production_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'batch_lot_no' => 'OIL-' . fake()->year() . '-' . fake()->numerify('###'),
            'time_checked' => fake()->time('H:i:s'),
            'oil_temperature_c' => $temp,
            'corrective_action' => $outOfRange ? fake()->sentence() : null,
            'created_at' => fake()->dateTimeBetween('-60 days', 'now'),
        ];
    }
}
