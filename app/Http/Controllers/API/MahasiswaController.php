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

    public function destroy($id){
        //
        $mahasiswas = Mahasiswa::where('id',$id);
        //hapus file foto
        unlink(public_path("public/".$mahasiswas->first()->foto));
        //hapus data mahasiswa
        if($mahasiswas->delete()){
            return $this->sendSuccess([], 'Data Mahasiswa Berhasil Dihapus', 303);
        }
        else{
                return $this->sendError('', 'Data Mahasiswa Gagal Dihapus', 400);
        }
    }

    public function update(Request $request, $id){
        //membuat validasi data
        $validasi = $request->validate([
            // 'npm' => 'required|unique:mahasiswas',
            // 'nama' => 'required',
            'tanggal_lahir' => '',
            'tempat_lahir' => '',
            'foto' => 'required|file|image|max:5000',
            'prodi_id' => ''
        ]);
        

        //simpan data di tabel mahasiswa
        $result = Mahasiswa::where('id', $id)->update($validasi);
        if(isset($request->foto)){
            //upload foto
            //ambil foto ke dalam folder
            $ext = $request->foto->getClientOriginalExtension();
            //rename file foto menjadi npm.jpg/npm.png
            $name_file_baru = $request->$result->frist()->npm.".".$ext;
            //upload file foto ke dalam folder public/images
            $file = $request->file('foto');
            $file->move('public',$name_file_baru);

            $validasi['foto'] = $name_file_baru;
            //simpan nama file baru ke dalam $validasi['foto']
            $result->update($validasi);
        }
        
        $result->update($validasi); //update data mahasiswa sesuai dengan $validasi pada tabel mahasiswa
            return $this->sendSuccess($result->first(), 'Mahasiswa berhasil diubah', 200);
        
    }

}
