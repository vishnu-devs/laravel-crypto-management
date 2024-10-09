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
        Schema::create('table_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_id'); // Ensure this matches the type of currencies.id
            $table->decimal('balance', 20, 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_balances');
    }
};
