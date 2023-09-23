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
}
