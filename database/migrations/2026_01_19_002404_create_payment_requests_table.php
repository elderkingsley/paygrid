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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained(); // The Requester
            $table->foreignUuid('expense_category_id')->constrained();

            $table->decimal('amount', 15, 2);
            $table->text('details');

            // Payment Info
            $table->string('bank_code');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name');

            // Workflow & Files
            $table->string('receipt_path')->nullable();
            $table->string('status')->default('pending'); // pending, approved, disbursed, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
