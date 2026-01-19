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
        Schema::create('expense_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('expense_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('category'); // e.g., Logistics, Maintenance
            $table->decimal('amount', 15, 2);
            $table->timestamps(); // <--- Ensure this is here
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_items');
    }
};
