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
        Schema::create('jawaban_siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('soal_id')->constrained('soals','id')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignUuid('jadwal_id')->constrained('jadwals','id')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignUuid('siswa_id')->constrained('siswas','id')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignUuid('bank_soal_id')->constrained('bank_soals','id')->cascadeOnUpdate()->restrictOnDelete();
            $table->text('jawaban_pg')->nullable();
            $table->longText('jawaban_esay')->nullable();
            $table->text('jawaban_isian_singkat')->nullable();
            $table->boolean('benar')->default(0);
            $table->boolean('ragu_ragu')->default(0);
            $table->boolean('dijawab')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
    }
};
