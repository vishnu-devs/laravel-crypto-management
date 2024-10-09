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
        Schema::create('table_profit_or_loss', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('purchase_bal_id');
            $table->decimal('purchase_rate', 10, 2);
            $table->decimal('sale_rate', 10, 2);
            $table->decimal('qty', 20, 10);
            $table->decimal('difference', 10, 2);
            $table->integer('profit_or_loss')->default('2'); // 0 for Loss, 1 for Profit, 2 for No change
            $table->timestamps();

            // Define foreign keys if applicable
            // Define foreign keys if necessary
            $table->foreign('sale_id')->references('id')->on('accounting_sales')->onDelete('cascade');
            $table->foreign('purchase_id')->references('id')->on('accounting_purchase')->onDelete('cascade');
            $table->foreign('purchase_bal_id')->references('id')->on('accounting_purchasebalances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_loss');
    }
};
