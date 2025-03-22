<?php

namespace App\Http\Controllers;

class WargaController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function DataWarga()
    {
        return view('warga.data');
    }
    public function FormWarga()
    {
        return view('warga.formwarga');
    }
}
