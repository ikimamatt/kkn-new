<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $month = $request->get('month');


        $query = Finance::with('user')->orderBy('date')->orderBy('id');

        if ($month) {
            $query->whereMonth('date', $month);
        }

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

        return view('finance.index', compact('finances'));
    }
}
