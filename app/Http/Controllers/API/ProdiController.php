<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class ProdiController extends BaseController
{
    //
    public function index(){
        //$prodi = Prodi::all();
        $prodi = Prodi::with('fakultas')->get();
        return $this->sendSuccess($prodi, 'Data fakultas', 200);

    }

    public function store(Request $request){
        $validasi = $request->validate([
            'nama_prodi' => 'required|unique:prodis',
            'fakultas_id' => 'required'
        ]);

        $result = Prodi::create($validasi);

        if($result){
            return $this->sendSuccess($result, 'Prodi berhasil ditambahkan', 201);
        }
        else{
            return $this->sendError('', 'Data gagal disimpan', 400);
        }
    }

}
