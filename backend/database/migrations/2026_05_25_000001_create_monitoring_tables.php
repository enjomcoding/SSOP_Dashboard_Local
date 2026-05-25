<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_material_logs', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name', 150);
            $table->date('agreed_scheduled_date')->nullable();
            $table->date('receiving_date');
            $table->time('time_received');
            $table->string('delivery_vehicle_id', 80)->nullable();
            $table->string('qc_inspector', 100);
            $table->string('raw_material', 150);
            $table->enum('packaging_condition', ['GOOD', 'DAMAGED'])->default('GOOD');
            $table->string('moisture_content_or_expiry', 150)->nullable();
            $table->boolean('within_specs')->default(true);
            $table->decimal('quantity', 10, 2);
            $table->enum('status', ['ACCEPTED', 'REJECTED'])->default('ACCEPTED');
            $table->string('inspector_initials', 10);
            $table->string('received_by', 100);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('delivery_truck_logs', function (Blueprint $table) {
            $table->id();
            $table->string('truck_plate_no', 20);
            $table->string('driver_name', 100);
            $table->string('checked_by', 100);
            $table->date('inspection_date');
            $table->time('inspection_time');
            $table->enum('exterior_condition', ['CLEAN', 'DIRTY'])->default('CLEAN');
            $table->enum('interior_condition', ['CLEAN', 'DIRTY'])->default('CLEAN');
            $table->enum('odor', ['NORMAL', 'UNUSUAL'])->default('NORMAL');
            $table->boolean('pest_activity')->default(false);
            $table->boolean('sanitized')->default(true);
            $table->boolean('maintenance_issues')->default(false);
            $table->string('inspector_initials', 10);
            $table->text('corrective_action')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('pest_control_logs', function (Blueprint $table) {
            $table->id();
            $table->date('inspection_date');
            $table->string('inspector_name', 100);
            $table->string('inspection_area', 150);
            $table->boolean('pest_activity_observed')->default(false);
            $table->string('type_of_pest', 100)->nullable();
            $table->text('corrective_action_taken')->nullable();
            $table->string('inspector_initials', 10);
            $table->string('verified_by_qa', 100)->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('oil_temperature_logs', function (Blueprint $table) {
            $table->id();
            $table->date('production_date');
            $table->string('batch_lot_no', 80);
            $table->string('operator_name_id', 100);
            $table->time('time_checked');
            $table->decimal('oil_temperature_c', 5, 2);
            $table->string('operator_initial', 10);
            $table->text('corrective_action')->nullable();
            $table->string('verified_by_qa', 100)->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('cleaning_logs', function (Blueprint $table) {
            $table->id();
            $table->date('log_date');
            $table->time('log_time');
            $table->string('area_of_concern', 150);
            $table->boolean('standard_met')->default(true);
            $table->text('action_taken')->nullable();
            $table->string('sanitizer_used', 100)->nullable();
            $table->string('performed_by', 100);
            $table->string('checked_by', 100)->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('stock_management_logs', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse_location', 150);
            $table->string('checked_by', 100);
            $table->date('log_date');
            $table->time('log_time');
            $table->string('product_name', 150);
            $table->string('batch_lot_no', 80);
            $table->decimal('quantity_in_stock', 10, 2);
            $table->date('expiry_date')->nullable();
            $table->enum('storage_condition', ['GOODS', 'NEEDS ATTENTION'])->default('GOODS');
            $table->boolean('fifo_fefo_followed')->default(true);
            $table->string('inspector_initials', 10);
            $table->text('corrective_action')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_management_logs');
        Schema::dropIfExists('cleaning_logs');
        Schema::dropIfExists('oil_temperature_logs');
        Schema::dropIfExists('pest_control_logs');
        Schema::dropIfExists('delivery_truck_logs');
        Schema::dropIfExists('raw_material_logs');
    }
};
