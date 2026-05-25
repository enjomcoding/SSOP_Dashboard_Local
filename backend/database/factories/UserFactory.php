<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    private const ROLES = [
        'QA',
        'QC_INSPECTOR',
        'OPERATOR',
        'WAREHOUSE',
        'PEST_INSPECTOR',
        'SUPERVISOR',
    ];

    public function definition(): array
    {
        $fullName = fake()->name();

        return [
            'full_name' => $fullName,
            'initials' => $this->initialsFromName($fullName),
            'role' => fake()->randomElement(self::ROLES),
        ];
    }

    public function role(string $role): static
    {
        return $this->state(fn () => ['role' => $role]);
    }

    private function initialsFromName(string $fullName): string
    {
        $parts = preg_split('/\s+/', trim($fullName)) ?: [];
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[count($parts) - 1], 0, 1));
        }

        return strtoupper(substr($parts[0] ?? 'U', 0, 2));
    }
}
