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
        Schema::create('bank_soals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('kode_bank_soal')->unique();
            $table->integer('jumlah_opsi_pg')->default(4)->comment('1:A,2:B,3:C,4:D');
            $table->integer('jumlah_soal')->default(0);
            $table->integer('tampil_esai');
            $table->integer('tampil_pg');
            $table->integer('tampil_kompleks');
            $table->integer('tampil_menjodohkan');
            $table->integer('tampil_benar_salah');
            $table->integer('tampil_benar_tidak');
            $table->longText("bobot")->default("[]")->comment("Isinya adalah bobot masing masing jenis soal dalam persen");
            $table->boolean('aktif')->default(false)->comment("1:Aktif dan 0: Tidak Aktif, artinya jika 0 maka bank soal ini tidak di ujikan");
            $table->boolean('lock')->default(false);
            $table->string('lock_by');
            $table->string('lock_key');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soals');
    }
};
