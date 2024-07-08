<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Models\KontenProgram;
use App\Models\KontenPenyaluran;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data['KontenPenyaluran']=KontenPenyaluran::all();
        $data['KontenProgram']=KontenProgram::all();
        return view('welcome', $data);
    }
}
