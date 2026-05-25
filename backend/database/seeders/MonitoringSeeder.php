<?php

namespace Database\Seeders;

use App\Models\CleaningLog;
use App\Models\DeliveryTruckLog;
use App\Models\OilTemperatureLog;
use App\Models\PestControlLog;
use App\Models\RawMaterialLog;
use App\Models\StockManagementLog;
use Illuminate\Database\Seeder;

class MonitoringSeeder extends Seeder
{
    public function run(): void
    {
        RawMaterialLog::insert([
            [
                'supplier_name' => 'Fresh Farms Co',
                'agreed_scheduled_date' => today(),
                'receiving_date' => today(),
                'time_received' => '08:30:00',
                'delivery_vehicle_id' => 'TRK-101',
                'qc_inspector' => 'Pedro Lim',
                'raw_material' => 'Chicken Breast',
                'packaging_condition' => 'GOOD',
                'moisture_content_or_expiry' => '12% moisture',
                'within_specs' => true,
                'quantity' => 500,
                'status' => 'ACCEPTED',
                'inspector_initials' => 'PL',
                'received_by' => 'Maria Santos',
                'created_at' => now(),
            ],
            [
                'supplier_name' => 'Dairy Direct',
                'agreed_scheduled_date' => null,
                'receiving_date' => today()->subDay(),
                'time_received' => '09:15:00',
                'delivery_vehicle_id' => null,
                'qc_inspector' => 'Ana Cruz',
                'raw_material' => 'Milk Powder',
                'packaging_condition' => 'DAMAGED',
                'moisture_content_or_expiry' => 'Exp 2026-08',
                'within_specs' => false,
                'quantity' => 250,
                'status' => 'REJECTED',
                'inspector_initials' => 'AC',
                'received_by' => 'John Reyes',
                'created_at' => now()->subDay(),
            ],
        ]);

        DeliveryTruckLog::insert([
            [
                'truck_plate_no' => 'ABC-1234',
                'driver_name' => 'Juan Dela Cruz',
                'checked_by' => 'Maria Santos',
                'inspection_date' => today(),
                'inspection_time' => '07:00:00',
                'exterior_condition' => 'CLEAN',
                'interior_condition' => 'CLEAN',
                'odor' => 'NORMAL',
                'pest_activity' => false,
                'sanitized' => true,
                'maintenance_issues' => false,
                'inspector_initials' => 'MS',
                'corrective_action' => null,
                'created_at' => now(),
            ],
            [
                'truck_plate_no' => 'XYZ-5678',
                'driver_name' => 'Rosa Garcia',
                'checked_by' => 'John Reyes',
                'inspection_date' => today()->subDay(),
                'inspection_time' => '08:30:00',
                'exterior_condition' => 'DIRTY',
                'interior_condition' => 'CLEAN',
                'odor' => 'UNUSUAL',
                'pest_activity' => true,
                'sanitized' => true,
                'maintenance_issues' => false,
                'inspector_initials' => 'JR',
                'corrective_action' => 'Interior deep clean required',
                'created_at' => now()->subDay(),
            ],
        ]);

        PestControlLog::insert([
            [
                'inspection_date' => today(),
                'inspector_name' => 'PestCo Inc',
                'inspection_area' => 'Warehouse B',
                'pest_activity_observed' => false,
                'type_of_pest' => null,
                'corrective_action_taken' => null,
                'inspector_initials' => 'PC',
                'verified_by_qa' => 'Maria Santos',
                'created_at' => now(),
            ],
            [
                'inspection_date' => today()->subDays(2),
                'inspector_name' => 'PestCo Inc',
                'inspection_area' => 'Receiving Dock',
                'pest_activity_observed' => true,
                'type_of_pest' => 'Rodents',
                'corrective_action_taken' => 'Bait stations replaced',
                'inspector_initials' => 'PC',
                'verified_by_qa' => 'Pedro Lim',
                'created_at' => now()->subDays(2),
            ],
        ]);

        OilTemperatureLog::insert([
            [
                'production_date' => today(),
                'batch_lot_no' => 'OIL-2026-100',
                'operator_name_id' => 'Carlos Mendez',
                'time_checked' => '10:00:00',
                'oil_temperature_c' => 175.50,
                'operator_initial' => 'CM',
                'corrective_action' => null,
                'verified_by_qa' => 'Maria Santos',
                'created_at' => now(),
            ],
            [
                'production_date' => today()->subDay(),
                'batch_lot_no' => 'OIL-2026-099',
                'operator_name_id' => 'Carlos Mendez',
                'time_checked' => '09:00:00',
                'oil_temperature_c' => 168.25,
                'operator_initial' => 'CM',
                'corrective_action' => 'Adjusted fryer setpoint',
                'verified_by_qa' => 'Ana Cruz',
                'created_at' => now()->subDay(),
            ],
        ]);

        CleaningLog::insert([
            [
                'log_date' => today(),
                'log_time' => '06:00:00',
                'area_of_concern' => 'Production Floor A',
                'standard_met' => true,
                'action_taken' => null,
                'sanitizer_used' => 'Quat Sanitizer',
                'performed_by' => 'Maria Santos',
                'checked_by' => 'John Reyes',
                'created_at' => now(),
            ],
            [
                'log_date' => today()->subDay(),
                'log_time' => '18:30:00',
                'area_of_concern' => 'Packaging Room',
                'standard_met' => false,
                'action_taken' => 'Re-cleaned conveyor belts',
                'sanitizer_used' => 'Chlorine-based',
                'performed_by' => 'Ana Cruz',
                'checked_by' => 'Maria Santos',
                'created_at' => now()->subDay(),
            ],
        ]);

        StockManagementLog::insert([
            [
                'warehouse_location' => 'Warehouse A - Rack 1',
                'checked_by' => 'Pedro Lim',
                'log_date' => today(),
                'log_time' => '11:00:00',
                'product_name' => 'Frozen Nuggets',
                'batch_lot_no' => 'PB-2026-100',
                'quantity_in_stock' => 1200,
                'expiry_date' => today()->addDays(180),
                'storage_condition' => 'GOODS',
                'fifo_fefo_followed' => true,
                'inspector_initials' => 'PL',
                'corrective_action' => null,
                'created_at' => now(),
            ],
            [
                'warehouse_location' => 'Warehouse A - Rack 3',
                'checked_by' => 'Ana Cruz',
                'log_date' => today()->subDays(2),
                'log_time' => '10:00:00',
                'product_name' => 'Veggie Patties',
                'batch_lot_no' => 'PB-2026-102',
                'quantity_in_stock' => 450,
                'expiry_date' => today()->addDays(14),
                'storage_condition' => 'NEEDS ATTENTION',
                'fifo_fefo_followed' => false,
                'inspector_initials' => 'AC',
                'corrective_action' => 'Moved to front for FEFO',
                'created_at' => now()->subDays(2),
            ],
        ]);
    }
}
