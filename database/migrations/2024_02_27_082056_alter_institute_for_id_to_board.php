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
        Schema::table('board', function (Blueprint $table) {
           
            $table->unsignedBigInteger('institute_for_id')->after('id');
            $table->foreign('institute_for_id')->references('id')->on('institute_for');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board', function (Blueprint $table) {
            //
        });
    }
};
