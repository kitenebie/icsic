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
            $table->string('lrn');
            $table->bigInteger('adviser_id')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('extension_name')->nullable();
            $table->date('birthdate');
            $table->boolean('is_learner_with_disability')->default(false);
            $table->enum('disability_type', [
                'Visual Impairment', 'Hearing Impairment', 'Learning Disability', 'Intellectual Disability',
                'blind', 'low vision', 'Speech/Language Disorder', 'Cerebral Palsy', 'Special Health Problem/Chronic Disease',
                'Multiple Disorder', 'Autism Spectrum Disorder', 'Emotional-Behavioral Disorder', 'Orthopedic/Physical Handicap',
                'Cancer'
            ])->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('current_address')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->integer('age');
            $table->boolean('with_lrn')->default(false);
            $table->boolean('returning_learner')->default(false);
            $table->enum('sex', ['Male', 'Female']);
            $table->boolean('indigenous_peoples')->default(false);
            $table->string('indigenous_peoples_specification')->nullable();
            $table->boolean('4ps_beneficiary')->default(false);
            $table->string('4ps_household_id')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_maiden_name')->nullable();
            $table->string('legal_guardian_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('last_grade_level_completed')->nullable();
            $table->string('last_school_year_completed')->nullable();
            $table->string('last_school_attended')->nullable();
            $table->string('school_id')->nullable();
            $table->enum('semester', ['1st', '2nd'])->nullable();
            $table->string('track')->nullable();
            $table->string('strand')->nullable();
            $table->enum('distance_learning_preference', ['Modular (Print)', 'Online', 'Radio-Based Instruction', 'Blended', 
                                                        'Modular (Digital)', 'Educational Television', 'Homeschooling'])->nullable();
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
