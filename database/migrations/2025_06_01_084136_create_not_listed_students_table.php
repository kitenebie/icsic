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
        Schema::create('not_listed_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parentId');
            $table->text('studentName');
            $table->text('ParentName');
            $table->enum('status', ['Requested','Already noticed','Already processed', 'Declined by the admin']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('not_listed_students');
    }
};
