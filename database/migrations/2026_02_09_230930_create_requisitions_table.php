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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('department_id')->constrained()->onDelete('cascade');

            // Use foreignId for budget because it uses a regular ID
            $table->foreignId('budget_id')->constrained()->onDelete('cascade');

            // FIX: The Requester (must be foreignUuid)
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->string('status')->default('pending');

            // FIX: The Approver and Disburser (must be foreignUuid)
            $table->foreignUuid('approver_id')->nullable()->constrained('users');
            $table->foreignUuid('disburser_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('requisitions');
    }
};
