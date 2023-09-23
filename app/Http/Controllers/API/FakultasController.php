<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class FakultasController extends BaseController
{
    //
    public function index(){
        $fakultas = Fakultas::all();
        return $this->sendSuccess($fakultas, 'Data Fakultas', 200);
    }

    public function store(Request $request){
        //membuat validasi data
        $validasi = $request->validate([
            'nama_fakultas' => 'required|unique:fakultas'
        ]);

        //simpan data ke tabel fakultas
        $result = Fakultas::create($validasi);

        if($result){ //jika data berhasil disimpan
            return $this->sendSuccess($result, 'Fakultas berhasil ditambahkan', 201);
        }
        else{ //jika data gagal disimpan
            return $this->sendError('', 'Data gagal disimpan', 400);
        }
    }

    public function destroy($id){
        //
        $fakultas = Fakultas::where('id',$id);
        //$fakultas = Fakultas::findOrfail($id);
        //jika ada data fakultas dengan id =$id
        if($fakultas->delete()){
            return $this->sendSuccess([], 'Data Fakultas Berhasil Dihapus', 303);
        }
        else{
                return $this->sendError('', 'Data Fakultas Gagal Dihapus', 400);
        }
    }
}
