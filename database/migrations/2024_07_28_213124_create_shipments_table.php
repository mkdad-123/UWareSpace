<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('employee_id')->unique()->constrained('employees')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete()->cascadeOnUpdate();
          //  $table->foreignId('sell_order_id')->constrained('sell_orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('tracking_number')->unique();
            $table->decimal('current_capacity')->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
