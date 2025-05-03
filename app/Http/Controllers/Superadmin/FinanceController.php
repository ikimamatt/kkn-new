<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinanceExport;

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

        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'item_name' => 'nullable|string',
            'quantity' => 'nullable|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:100',
            'description' => 'nullable|string',
        ]);

        $quantity = $validated['quantity'] ?
            $validated['quantity'] :
            null;

        $total = $validated['quantity'] ?
            $validated['quantity'] * $validated['unit_price'] :
            $validated['unit_price'];

        $data = [...$request->all(), 'total' => $total, 'quantity' => $quantity];

        Finance::create($data);

        return redirect()->route('superadmin.finance.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'item_name' => 'nullable|string',
            'quantity' => 'nullable|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:100',
            'description' => 'nullable|string',
        ]);

        $data = $request->except(['_token', '_method', 'id']);

        $quantity = $validated['quantity'] ?
            $validated['quantity'] :
            null;

        $total = $validated['quantity'] ?
            $validated['quantity'] * $validated['unit_price'] :
            $validated['unit_price'];

        $data = [...$data, 'total' => $total, 'quantity' => $quantity];

        Finance::where('id', operator: $id)->update($data);

        return redirect()->route('superadmin.finance.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $finance = Finance::findOrFail($id);
        $finance->delete();

        return redirect()->route('superadmin.finance.index')->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new FinanceExport, 'keuangan.xlsx');
    }
}
