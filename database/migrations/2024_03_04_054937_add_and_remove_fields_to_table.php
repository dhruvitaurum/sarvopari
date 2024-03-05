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
        Schema::table('subject', function (Blueprint $table) {
            $table->dropForeign(['standard_id']);
            $table->dropForeign(['stream_id']);
            $table->dropColumn('standard_id');
            $table->dropColumn('stream_id');

           
            $table->integer('base_table_id')->after('id');
            $table->foreign('base_table_id')->references('id')->on('base_table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subject', function (Blueprint $table) {
            //
        });
    }
};
