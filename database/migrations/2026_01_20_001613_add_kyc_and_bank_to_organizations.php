<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            // KYC Fields
            $table->string('cac_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->boolean('kyc_verified')->default(false);

            // Paystack & Banking Fields
            //$table->string('paystack_customer_code')->nullable(); // needed to request account
            //$table->string('virtual_account_number')->nullable();
            //$table->string('virtual_bank_name')->nullable();
            //$table->string('virtual_account_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            //
        });
    }
};
