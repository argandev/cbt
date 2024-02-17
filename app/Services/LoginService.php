<?php

namespace App\Services;

use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * dadandev
 * @class LoginService
 */
final class LoginService
{
    public SiswaModel $siswaModel;
    public function __construct(){

    }
    //service body
    public function validasi($data)
    {
        $userValidator =  Validator::make($data, [
            'kode_peserta' => "required|string|max:10",
            "password" => "required"
        ]);
        if ($userValidator->fails()) {
            return $userValidator->errors();
        }
        return !false;
    }
    public function loginSiswa(array $data)
    {
        $validated = $this->validasi($data);
        //jika validasi nya true
        if ($validated === true && is_bool($validated)) {
        //cek user berdasarkan kode peserta
            $siswa = Siswa::with('kelas')->whereKodePeserta($data['kode_peserta'])->first();
            if ( $siswa ) {
                //cek password
                if ( password_verify($data['password'],$siswa->password) ) {
                    $siswa->update([
                        'api_token' => $siswa->id."|".md5(time()),
                    ]);
                    return [
                        'user' => $siswa
                    ];
                }
            }

        } else {
            return [
                'errors' => $validated->messages(),
            ];
        }
    }
}
