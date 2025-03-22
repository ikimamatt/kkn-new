<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\House;
use Illuminate\Http\Request;

class BlokController extends Controller
{
    public function index()
    {
        return view('warga.blok');
    }

    public function show($block)
    {
        // Menyaring blok berdasarkan nama
        $blockData = Block::where('name', $block)->first();

        if (!$blockData) {
            abort(404, 'Block not found');
        }

        // Ambil data rumah yang ada pada blok ini
        $houses = House::where('block_id', $blockData->id)->get();

        return view('blok.show', compact('blockData', 'houses'));
    }
}
