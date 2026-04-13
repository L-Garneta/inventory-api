<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('transaksi_masuk', function (Blueprint $table) {
        $table->id();
        $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
        $table->date('tanggal');
        $table->integer('jumlah');
        $table->string('supplier')->nullable();
        $table->enum('status', ['pending', 'completed'])->default('pending');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('transaksi_masuk');
}
};
