<?php

namespace App\Http\Controllers\kegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function ListKegiatan()
    {
    return view('kegiatan.ListKegiatan');
    }
    
    public function absensi()
    {
        return view('kegiatan.absensi');
    }
}
