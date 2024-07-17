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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('SKU');
            $table->string('name');
            $table->decimal('sell_price' , 12);
            $table->decimal('pur_price' , 12 );
            $table->decimal('size_cubic_meters')->nullable();
            $table->decimal('weight')->nullable();
            $table->decimal('str_price')->nullable();
            $table->integer('total_qty')->default('0');
            $table->string('photo')->nullable();
            $table->string('unit');
            $table->timestamps();

            $table->unique(['SKU','admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
