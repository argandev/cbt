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
        Schema::create('siswa_ujians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('siswa_id')->constrained('siswas','id')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignUuid('jadwal_id')->constrained('jadwals','id')->cascadeOnUpdate()->restrictOnDelete();
            $table->time('waktu_start');
            $table->time('waktu_end')->nullable();
            $table->integer('sisa_waktu')->nullable();
            $table->boolean('status_ujian')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_ujians');
    }
};
