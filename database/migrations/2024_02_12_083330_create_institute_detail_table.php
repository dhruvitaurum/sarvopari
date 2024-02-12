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
        Schema::create('institute_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institute_for_id');
            $table->foreign('institute_for_id')->references('id')->on('institute_for')->onDelete('cascade');
            $table->unsignedBigInteger('institute_board_id');
            $table->foreign('institute_board_id')->references('id')->on('institute_board')->onDelete('cascade');
            $table->unsignedBigInteger('institute_for_class_id');
            $table->foreign('institute_for_class_id')->references('id')->on('institute_for_class')->onDelete('cascade');
            $table->unsignedBigInteger('institute_medium_id');
            $table->foreign('institute_medium_id')->references('id')->on('institute_medium')->onDelete('cascade');
            $table->unsignedBigInteger('institute_work_id');
            $table->foreign('institute_work_id')->references('id')->on('institute_work')->onDelete('cascade');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('institute_subject')->onDelete('cascade');
           
            $table->string('institute_name');
            $table->string('address');
            $table->integer('contact_no');
            $table->string('email');
            $table->string('subject');
            $table->enum('status',['active','inactive']);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institute_detail');
    }
};
