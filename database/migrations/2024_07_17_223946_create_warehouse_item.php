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
        Schema::create('warehouse_item', function (Blueprint $table) {
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('real_qty');
            $table->integer('min_qty');
            $table->integer('available_qty');
            $table->timestamps();

            $table->primary(['item_id' , 'warehouse_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_item');
    }
};
