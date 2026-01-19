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
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained();
            $table->foreignUuid('vendor_id')->constrained();
            $table->foreignUuid('user_id')->constrained(); // Who created it
            $table->date('payment_date');
            $table->decimal('total_amount', 15, 2);
            $table->string('status')->default('pending'); // pending, approved, paid
            $table->timestamps(); // <--- MAKE SURE THIS IS HERE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
