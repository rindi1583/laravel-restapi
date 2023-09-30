<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    //
    public function register(Request $request){
        $validasi = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        $validasi['password'] =  bcrypt(($request['password']));
        //simpan dlm tabel user
        $result = User::create($validasi);
        if($result){ //jika data berhasil disimpan
            return $this->sendSuccess($result, 'user berhasil ditambahkan', 201);
        }
        else{ //jika data gagal disimpan
            return $this->sendError('', 'user gagal ditambah', 400);
        }
    }

    public function login(Request $request){
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            //jika email dan password benar
            //amnil data user
            $user = Auth::user();
            //buat token
            $result['token'] = $user->createToken('MI5AApp')->plainTextToken;
            return $this->sendSuccess($result, 'user berhasil login', 200);
            
            }else{ //jika data gagal disimpan
                return $this->sendError([], 'email atau password salah', 400);
        }
    }
}
