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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bank_soal_id')
            ->constrained('bank_soals','id')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
            //untuk kelas apa aja ini ujian jika kosong berarti umum atau semua kelas
            $table->text('kelas_ids')->comment('untuk kelas apa aja ini ujian jika kosong berarti umum atau semua kelas');
            $table->string('nama');
            $table->integer('lama_ujian')->comment('dalam_menit');
            $table->date('tanggal_mulai');
            $table->date('tanggal_expired');
            $table->time('waktu_mulai');
            $table->boolean('lihat_hasil');
            $table->integer('pengerjaan_minimal');
            $table->json('setting')->default('[]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
