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
        Schema::create('expense_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuId('organization_id')->constrained()->cascadeOnDelete();

            // Persona 1: The Requester
            $table->foreignUuId('user_id')->constrained()->comment('The person asking for money');

            // Persona 2: The Approver
            $table->foreignUuId('approver_id')->nullable()->constrained('users');

            // Persona 3: The Disburser
            $table->foreignUuId('disburser_id')->nullable()->constrained('users');

            $table->string('title');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'disbursed', 'declined'])->default('pending');

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_requests');
    }
};
