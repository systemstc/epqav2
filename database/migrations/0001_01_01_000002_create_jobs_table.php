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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue',100)->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        // Schema::create('job_batches', function (Blueprint $table) {
        //     $table->string('id',100)->primary();
        //     $table->string('name',100);
        //     $table->integer('total_jobs',100);
        //     // $table->integer('pending_jobs',100);
        //     // $table->integer('failed_jobs',100);
        //     // $table->longText('failed_job_ids');
        //     // $table->mediumText('options')->nullable();
        //     // $table->integer('cancelled_at',100)->nullable();
        //     // $table->integer('created_at',100);
        //     // $table->integer('finished_at',100)->nullable();
        // });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid',100)->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
