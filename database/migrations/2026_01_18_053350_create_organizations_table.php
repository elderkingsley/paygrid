<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_organizations_table.php
public function up(): void
{
    Schema::create('organizations', function (Blueprint $table) {
        $table->uuid('id')->primary(); // UUID Primary Key
        $table->string('name');
        $table->string('slug')->unique();
        $table->string('paystack_customer_code')->nullable();
        $table->string('nuban')->nullable();
        $table->decimal('wallet_balance', 15, 2)->default(0.00);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
