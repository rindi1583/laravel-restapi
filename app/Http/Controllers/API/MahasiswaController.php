<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
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

    public function store(Request $request){
        $validasi = $request->validate([
            'npm' => 'required|unique:mahasiswas',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required',
            'foto' => 'required|file|image|max:5000',
            'prodi_id' => 'required'
        ]);

        //upload foto
        //ambil ekstensi file yang diupload
        $ext = $request->foto->getClientOriginalExtension();
        //rename file foto
        $name_file_baru = $request->npm.".".$ext;
        //upload file foto
        $file = $request->file('foto');
        $file->move('public',$name_file_baru);

        $validasi['foto'] = $name_file_baru;

        //simpan data di tabel mahasiswa
        $result = Mahasiswa::create($validasi);
        return $this->sendSuccess($result, 'Mahasiswa berhasil ditambahkan', 201);
    }

}
