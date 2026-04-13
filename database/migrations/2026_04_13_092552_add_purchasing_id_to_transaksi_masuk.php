<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::table('transaksi_masuk', function (Blueprint $table) {
            $table->unsignedBigInteger('purchasing_id')->nullable();

            $table->foreign('purchasing_id')
                ->references('id')
                ->on('purchasing')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_masuk', function (Blueprint $table) {
            //
        });
    }
};
