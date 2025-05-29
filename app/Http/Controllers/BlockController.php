<?php
namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    // Menampilkan semua blok
    public function index()
    {
        $blocks = Block::all();
        return view('warga.blok', compact('blocks'));
    }

    // Menyimpan data blok
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:blocks,name']);
        Block::create($request->all());

        // Menambahkan pesan sukses
        return redirect()->route('block.index')->with('success', 'Blok berhasil ditambahkan!');
    }

    // Menampilkan form edit blok
    public function edit(Block $block)
    {
        return view('block.edit', compact('block'));
    }

    // Memperbarui data blok
    public function update(Request $request, Block $block)
    {
        $request->validate(['name' => 'required|unique:blocks,name,' . $block->id]);
        $block->update($request->all());

        // Menambahkan pesan sukses
        return redirect()->route('block.index')->with('success', 'Blok berhasil diperbarui!');
    }

    // Menghapus blok
    public function destroy(Block $block)
    {
        $block->delete();

        // Menambahkan pesan sukses
        return redirect()->route('block.index')->with('success', 'Blok berhasil dihapus!');
    }

    // Mengambil data blok untuk update modal
    public function show(Block $block)
    {
        return response()->json($block);
    }
}
