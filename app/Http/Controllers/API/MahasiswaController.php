<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class MahasiswaController extends BaseController
{
    //
    public function index()
    {
        $mahasiswas = Mahasiswa::with('prodi.fakultas')->get();
        return $this->sendSuccess($mahasiswas, 'Data mahasiswa', 200);
    }
    
}
