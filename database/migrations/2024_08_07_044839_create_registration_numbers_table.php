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
        Schema::create('registration_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('firm_id');
            $table->string('registration_no',255);
            $table->timestamp('issue_date')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->enum('status',['0','1'],'1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_numbers');
    }
};
