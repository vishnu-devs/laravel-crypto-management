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
        Schema::create('accounting_purchase', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_id'); // Ensure this matches the type of currencies.id
            $table->decimal('qty', 15, 8); // Adjust precision and scale as needed
            $table->decimal('rate', 15, 8); // Adjust precision and scale as needed
            $table->timestamp('timing');
            $table->timestamps();
            
            // Define foreign key relationship
            $table->foreign('currency_id')->references('id')->on('currency')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_purchase');
    }
};
