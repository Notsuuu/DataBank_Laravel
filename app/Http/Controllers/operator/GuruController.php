<?php

namespace App\Http\Controllers\operator; 

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $para_guru = Guru::all();

        return view('operator.guru.index', compact('para_guru'));
    }
//maish mau lanjut nanti fungsi store dan lain lain
}