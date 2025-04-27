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
        Schema::create('jadwal_penerbangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maskapai_id')->constrained('maskapais')->onDelete('cascade');
            $table->foreignId('kota_asal_id')->constrained('kotas')->onDelete('cascade');
            $table->foreignId('kota_tujuan_id')->constrained('kotas')->onDelete('cascade');
            $table->date('tanggal_berangkat');
            $table->time('jam_berangkat');
            $table->time('jam_tiba');
            $table->decimal('harga_tiket', 12, 2);
            $table->integer('kapasitas_kursi');
            $table->integer('sisa_kursi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_penerbangans');
    }
};
