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
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affected_user_id'); // user being modified
            $table->unsignedBigInteger('performed_by_user_id')->nullable(); // who did it (nullable for system changes)
            $table->string('action'); // created, updated, deleted
            $table->json('before')->nullable(); // for update/delete
            $table->json('after')->nullable(); // for create/update
            $table->timestamps();

            $table->foreign('affected_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('performed_by_user_id')->references('id')->on('users')->onDelete('set null');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logs');
    }
};
