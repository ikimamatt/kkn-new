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

        $finances = $finances->paginate($perPage)->appends(request()->query());

        return view('superadmin.finance.index', compact('finances'));

    }
}
