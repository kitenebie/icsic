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
        Schema::create('students', function (Blueprint $table) {
            
            $table->id();
            $table->string('profile')->nullable();
            $table->string('lrn')->unique();
            $table->date('birthday');
            $table->string('permanent_address');
            $table->enum('gender', ['Male', 'Female', 'Other']);

            $table->string('grade')->nullable();
            $table->string('section')->nullable();
            $table->string('email')->unique();

            $table->string('guardian_name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('guardian_contact_number')->nullable();
            $table->string('guardian_email')->nullable();
            $table->year('year_graduated')->nullable();
            $table->enum('remarks', ['pending', 'member'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
