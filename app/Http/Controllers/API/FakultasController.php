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
}
