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
        Schema::table('matpels', function (Blueprint $table) {
            $table->foreignUuid('jurusan_id')->nullable()->default(NULL)->after('nama')->constrained('jurusans','id')->restrictOnDelete()->cascadeOnUpdate();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matpels', function (Blueprint $table) {
            //
        });
    }
};
