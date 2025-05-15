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

        $query = Finance::with('user')->orderBy('date')->orderBy('id');

        // Hitung running balance
        $allFinances = $query->get();

        $balance = 0;
        $allFinances = $allFinances->map(function ($finance) use (&$balance) {
            $balance += $finance->type === 'income'
                ? $finance->total
                : -$finance->total;

            $finance->running_balance = $balance;
            return $finance;
        });

        // Sort by date
        $allFinances = $allFinances->sortByDesc('date')->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $paginated = $allFinances->slice(($page - 1) * $perPage, $perPage)->values();

        $finances = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginated,
            $allFinances->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

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

        $data = [...$validated, 'total' => $total, 'quantity' => $quantity, 'created_by' => auth()->id()];

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
