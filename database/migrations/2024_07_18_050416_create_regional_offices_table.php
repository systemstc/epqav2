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
        Schema::create('regional_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name','899');
            $table->string('officer_incharge','899');
            $table->string('phone','899');
            $table->string('email','899');
            $table->string('lat','899');
            $table->string('lng','899');
            $table->string('state','899');
            $table->string('state_code','899');
            $table->string('short_code','255');
            $table->string('city','899');
            $table->enum('status',['0','1']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regional_offices');
    }
};
