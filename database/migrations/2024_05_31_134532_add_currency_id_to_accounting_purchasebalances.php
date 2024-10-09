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
        // Check if the column already exists before adding it
        if (!Schema::hasColumn('accounting_purchasebalances', 'currency_id')) {
            Schema::table('accounting_purchasebalances', function (Blueprint $table) {
                $table->unsignedBigInteger('currency_id')->after('purchase_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounting_purchasebalances', function (Blueprint $table) {
            // Drop the column if it exists
            if (Schema::hasColumn('accounting_purchasebalances', 'currency_id')) {
                $table->dropColumn('currency_id');
            }
        });
    }
};
