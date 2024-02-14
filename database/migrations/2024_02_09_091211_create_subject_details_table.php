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
        Schema::create('subject_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_chapter_id');
            $table->foreign('subject_chapter_id')->references('id')->on('subject_chapters');
            $table->string('topic_no');
            $table->string('topic_name');
            $table->string('topic_video')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_details');
    }
};
