<?php

namespace Database\Factories;

use App\Models\CleaningLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CleaningLog>
 */
class CleaningLogFactory extends Factory
{
    protected $model = CleaningLog::class;

    public function definition(): array
    {
        $standardMet = fake()->boolean(85);

        return [
            'log_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'log_time' => fake()->time('H:i:s'),
            'area_of_concern' => fake()->randomElement([
                'Production Floor A',
                'Packaging Room',
                'Cold Storage',
                'Receiving Dock',
                'Break Room',
            ]),
            'standard_met' => $standardMet,
            'action_taken' => $standardMet ? null : fake()->sentence(),
            'sanitizer_used' => fake()->randomElement([
                'Quat Sanitizer',
                'Chlorine-based',
                'Alcohol wipe',
                null,
            ]),
            'created_at' => fake()->dateTimeBetween('-60 days', 'now'),
        ];
    }
}
