<?php

namespace Database\Seeders;

use App\Models\CleaningLog;
use App\Models\DeliveryTruckLog;
use App\Models\OilTemperatureLog;
use App\Models\PestControlLog;
use App\Models\Product;
use App\Models\RawMaterialLog;
use App\Models\StockManagementLog;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class MonitoringSeeder extends Seeder
{
    private const LOG_COUNT = 50;

    public function run(): void
    {
        User::factory()->count(3)->role('QA')->create();
        User::factory()->count(3)->role('QC_INSPECTOR')->create();
        User::factory()->count(2)->role('OPERATOR')->create();
        User::factory()->count(1)->role('WAREHOUSE')->create();
        User::factory()->count(1)->role('PEST_INSPECTOR')->create();

        Supplier::factory()->count(10)->create();
        Product::factory()->count(20)->create();

        $allUserIds = User::pluck('id');
        $qcInspectorIds = User::where('role', 'QC_INSPECTOR')->pluck('id');
        $qaIds = User::where('role', 'QA')->pluck('id');
        $operatorIds = User::where('role', 'OPERATOR')->pluck('id');
        $pestInspectorIds = User::where('role', 'PEST_INSPECTOR')->pluck('id');
        $supplierIds = Supplier::pluck('id');
        $productIds = Product::pluck('id');

        $pick = fn (Collection $ids, ?Collection $fallback = null) => $ids->isNotEmpty()
            ? $ids->random()
            : ($fallback ?? $allUserIds)->random();

        RawMaterialLog::factory()
            ->count(self::LOG_COUNT)
            ->state(fn () => [
                'supplier' => fake()->company(),
                'qc_inspector_name' => fake()->name(),
                'received_by_name' => fake()->name(),
            ])
            ->create();

        DeliveryTruckLog::factory()
            ->count(self::LOG_COUNT)
            ->state(fn () => [
                'checked_by_name' => fake()->name(),
            ])
            ->create();

        PestControlLog::factory()
            ->count(self::LOG_COUNT)
            ->state(fn () => [
                'inspector_name' => fake()->name(),
                'verified_by_qa_name' => fake()->boolean(70) ? fake()->name() : null,
            ])
            ->create();

        OilTemperatureLog::factory()
            ->count(self::LOG_COUNT)
            ->state(fn () => [
                'operator_name' => fake()->name(),
                'verified_by_qa_name' => fake()->boolean(60) ? fake()->name() : null,
            ])
            ->create();

        CleaningLog::factory()
            ->count(self::LOG_COUNT)
            ->state(fn () => [
                'performed_by_name' => fake()->name(),
                'checked_by_name' => fake()->boolean(75) ? fake()->name() : null,
            ])
            ->create();

        StockManagementLog::factory()
            ->count(self::LOG_COUNT)
            ->state(fn () => [
                'checked_by_name' => fake()->name(),
                'product_id' => $productIds->random(),
            ])
            ->create();
    }
}
