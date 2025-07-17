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
        Schema::create('firms', function (Blueprint $table) {
            $table->id();
            $table->int('user_id');
            $table->int('subadmin_selected');
            $table->string('firm_name');
            $table->timestamps('dob');
            $table->string('address');
            $table->string('nature_of_firm');
            $table->string('postal_address');
            // $table->string('office_type');
            $table->string('telephone');
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('manufacturing_address')->nullable();
            $table->string('manufacturing_telephone')->nullable();
            $table->string('manufacturing_fax')->nullable();
            $table->boolean('is_merchant_exporter');
            $table->boolean('category_of_export');
            $table->year('year_of_establishment');
            $table->string('ie_code');
            $table->string('pan_number');
            $table->string('gstin_number');
            $table->date('ie_code_date');
            $table->text('commodities');
            $table->text('payment_details');
            $table->enum('status',['10','20','30','40','50','0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firms');
    }
};
