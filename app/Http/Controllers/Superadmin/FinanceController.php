<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');

        $finances = Finance::with('user');

        if ($search) {
            $finances = $finances->where('item_name', 'like', "%$search%");
        }

        $finances = $finances->orderBy('created_at', 'desc');

        $finances = $finances->paginate($perPage)->appends(request()->query());

        return view('superadmin.finance.index', compact('finances'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'item_name' => 'nullable|string',
            'quantity' => 'nullable|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:100',
            'description' => 'nullable|string',
        ]);

        $quantity = $request->input('quantity') ?
            $request->input('quantity') :
            null;

        $total = $request->input('quantity') ?
            $request->input('quantity') * $request->input('unit_price') :
            $request->input('unit_price');

        $data = [...$request->all(), 'total' => $total, 'quantity' => $quantity];

        Finance::create($data);

        return redirect()->route('superadmin.finance.index')->with('success', 'Data berhasil ditambahkan');
    }
}
