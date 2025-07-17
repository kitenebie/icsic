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
        Schema::create('announcement_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id'); // reply to main comment ID
            $table->bigInteger('commentatorId'); // reply to main comment ID
            $table->enum('type', ['main', 'reply']);
            $table->bigInteger('reply_to')->nullable(); // reply to main comment ID
            $table->longText('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcement_comments');
    }
};
