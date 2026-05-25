<?php

namespace Database\Factories;

use App\Models\PestControlLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PestControlLog>
 */
class PestControlLogFactory extends Factory
{
    protected $model = PestControlLog::class;

    public function definition(): array
    {
        $pestObserved = fake()->boolean(20);

        return [
            'inspection_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'inspection_area' => fake()->randomElement([
                'Warehouse A',
                'Warehouse B',
                'Receiving Dock',
                'Production Floor A',
                'Cold Storage',
            ]),
            'pest_activity_observed' => $pestObserved,
            'type_of_pest' => $pestObserved ? fake()->randomElement(['Rodents', 'Insects', 'Birds']) : null,
            'corrective_action_taken' => $pestObserved ? fake()->sentence() : null,
            'created_at' => fake()->dateTimeBetween('-60 days', 'now'),
        ];
    }
}
