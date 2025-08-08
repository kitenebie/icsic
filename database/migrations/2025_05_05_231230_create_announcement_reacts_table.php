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
        Schema::create('announcement_reacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id'); //id san user na nag-react
            $table->bigInteger('post_id'); //id san post/comment/reply
            $table->enum('type',['post', 'comment', 'reply']); //type 
            $table->text('react');
            $table->bigInteger('count');
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcement_reacts');
    }
};
