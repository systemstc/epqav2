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
        Schema::create('renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('firm_id')->constrained()->onDelete('cascade');
            $table->timestamp('applied_date')->nullable(); // Use timestamp for custom columns
            $table->timestamp('issue_date')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->enum('status', ['0', '1'])->default('1'); // Default value for enum
            $table->timestamps(); // This creates created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewals');
    }
};
