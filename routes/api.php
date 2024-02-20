<?php

use App\Http\Controllers\Api\V2\JadwalController;
use App\Http\Controllers\Api\V2\SiswaController;
use App\Http\Controllers\Api\V2\UjianController;
use App\Http\Middleware\SiswaLoginMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get('/',function(){
    return [];
});
Route::post('/v2/siswa/login', [SiswaController::class,'login']);
Route::middleware(SiswaLoginMiddleware::class)->group(function(){
    Route::get('/v2/siswa/me',[SiswaController::class,'me']);
    Route::get('/v2/siswa/get_jadwal',[JadwalController::class,'getJadwal']);
    Route::post('/v2/siswa/detail_jadwal',[JadwalController::class,'detail_jadwal']);
    Route::post('/v2/siswa/ujian/konfirmasi',[UjianController::class,'konfirmasi']);
    Route::get('/v2/siswa/ujian/jawaban_siswa',[UjianController::class,'getJawaban']);
});
