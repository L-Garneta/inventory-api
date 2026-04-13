<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('inventaris', function (Blueprint $table) {
        $table->id();
        $table->string('kode_inventaris')->unique();
        $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
        $table->unsignedBigInteger('transaksi_masuk_id');
        $table->string('status')->default('aktif');
        $table->timestamps();

        $table->foreign('transaksi_masuk_id')
            ->references('id')
            ->on('transaksi_masuk')
            ->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('inventaris');
}

};
