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
        Schema::create('news_pages', function (Blueprint $table) {
            $table->id();
            $table->string('topic_category');
            $table->json('relevant_topic');
            $table->string('title');
            $table->string('author');
            $table->string('author_description')->nullable();
            $table->date('pub_date')->nullable();
            $table->double('read_duration')->nullable();
            $table->integer('views')->nullable();
            $table->string('image');
            $table->json('content');
            $table->json('groups')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_pages');
    }
};
