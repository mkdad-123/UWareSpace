<?php

use App\Enums\PurchaseOrderEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('purchase__orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('status')->default(PurchaseOrderEnum::PENDING);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('purchase__orders');
    }
};
