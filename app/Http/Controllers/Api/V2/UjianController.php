<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function konfirmasi(Request $request) {
        dump($request->get('siswa_data'));
    }
}
