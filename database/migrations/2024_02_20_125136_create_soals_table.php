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
        Schema::create('soals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bank_soal_id')->constrained('bank_soals','id')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('tipe_soal',['pg','esay','menjodohkan'])->default(null)->nullable();
            $table->text('pertanyaan')->nullable();
            $table->string('audio_source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
