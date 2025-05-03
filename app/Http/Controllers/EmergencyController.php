<?php

// app/Http/Controllers/EmergencyController.php
namespace App\Http\Controllers;

use App\Models\EmergencyUnit;
use App\Models\EmergencyNumber;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    // Halaman daftar unit darurat
    public function index()
    {
        $units = EmergencyUnit::all();
        return view('emergency.unit', compact('units'));
    }

    // Halaman detail unit darurat beserta nomor-nomornya
    public function show(EmergencyUnit $unit)
    {
        $numbers = $unit->numbers;
        return view('emergency.numbers', compact('unit', 'numbers'));
    }

    // Halaman form untuk membuat unit darurat
    public function createUnit()
    {
        return view('emergency_units.create');
    }

    // Menyimpan unit darurat baru
    public function storeUnit(Request $request)
    {
        EmergencyUnit::create($request->all());
        return redirect()->route('emergency_units.index');
    }

    // Halaman form untuk mengedit unit darurat
    public function editUnit(EmergencyUnit $unit)
    {
        return view('emergency_units.edit', compact('unit'));
    }

    // Update unit darurat
    public function updateUnit(Request $request, EmergencyUnit $unit)
    {
        $unit->update($request->all());
        return redirect()->route('emergency_units.index');
    }

    // Menghapus unit darurat
    public function destroyUnit(EmergencyUnit $unit)
    {
        $unit->delete();
        return redirect()->route('emergency_units.index');
    }

    // Halaman form untuk membuat nomor darurat
    public function createNumber(EmergencyUnit $unit)
    {
        return view('emergency_numbers.create', compact('unit'));
    }

    // Menyimpan nomor darurat baru
    public function storeNumber(Request $request, EmergencyUnit $unit)
    {
        $unit->numbers()->create($request->all());
        return redirect()->back(); // Kembali ke halaman sebelumnya
    }

    // Halaman form untuk mengedit nomor darurat
    public function editNumber(EmergencyNumber $number)
    {
        return view('emergency_numbers.edit', compact('number'));
    }

    // Update nomor darurat
    public function updateNumber(Request $request, EmergencyNumber $number)
    {
        $number->update($request->all());
        return redirect()->back();
    }

    // Menghapus nomor darurat
    public function destroyNumber(EmergencyNumber $number)
    {
        $number->delete();
        return redirect()->back();
    }
}
