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
            // Only add the column if it doesn't exist yet
            if (!Schema::hasColumn('organizations', 'wallet_balance')) {
                $table->decimal('wallet_balance', 15, 2)->default(0.00)->after('paystack_customer_code');
            }
        });
    }

    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('wallet_balance');
        });
    }
};
