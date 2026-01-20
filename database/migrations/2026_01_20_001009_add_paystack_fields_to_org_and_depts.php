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
        if (!Schema::hasColumn('organizations', 'paystack_customer_code')) {
            $table->string('paystack_customer_code')->nullable();
        }
        if (!Schema::hasColumn('organizations', 'virtual_account_number')) {
            $table->string('virtual_account_number')->nullable();
        }
        if (!Schema::hasColumn('organizations', 'virtual_bank_name')) {
            $table->string('virtual_bank_name')->nullable();
        }
    });

    Schema::table('departments', function (Blueprint $table) {
        if (!Schema::hasColumn('departments', 'paystack_dedicated_account_id')) {
            $table->string('paystack_dedicated_account_id')->nullable();
        }
        if (!Schema::hasColumn('departments', 'virtual_account_number')) {
            $table->string('virtual_account_number')->nullable();
        }
        if (!Schema::hasColumn('departments', 'virtual_account_name')) {
            $table->string('virtual_account_name')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_and_depts', function (Blueprint $table) {
            //
        });
    }
};
