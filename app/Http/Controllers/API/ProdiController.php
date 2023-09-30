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

    public function destroy($id){
        //
        $prodi = Prodi::where('id',$id);
        if($prodi->delete()){
            return $this->sendSuccess([], 'Data Prodi Berhasil Dihapus', 303);
        }
        else{
                return $this->sendError('', 'Data Prodi Gagal Dihapus', 400);
        }
    }

    public function update(Request $request, $id){
        //membuat validasi data
        $validasi = $request->validate([
            'nama_prodi' => 'required|unique:prodis',
            'fakultas_id' => 'required'
        ]);
        $result = Prodi::where('id', $id)->update($validasi);
        $result->update($validasi);
        if($result){ //jika data berhasil disimpan
            return $this->sendSuccess($result->first(), 'Prodi berhasil diubah', 200);
        }
        else{ //jika data gagal disimpan
            return $this->sendError('', 'Prodi Data gagal diubah', 400);
        }
    }

}
