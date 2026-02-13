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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id(); // The budget itself can still use a regular ID

            // Link to the Organization (UUID)
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');

            // Link to the Department (UUID) - Updated to foreignUuid
            $table->foreignUuid('department_id')->constrained()->onDelete('cascade');

            $table->string('description')->nullable()->after('department_id');

            // Financial Columns
            $table->decimal('allocated_amount', 15, 2)->default(0.00);
            $table->decimal('spent_amount', 15, 2)->default(0.00);
            $table->decimal('reserved_amount', 15, 2)->default(0.00)->after('allocated_amount');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
