<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchasing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('supplier')->nullable();
            $table->string('status')->default('dipesan'); // dipesan, dikirim, sampai
            $table->date('tanggal_pesan');
            $table->boolean('is_processed')->default(false); // anti double insert
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchasing');
    }
};