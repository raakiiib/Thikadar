<?php

namespace App\Http\Controllers;

use App\Models\DailyExpense;
use App\Models\RawMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class SupplierController extends Controller
{


    public function index()
    {
        return Inertia::render('Expenses/DailyExpIndex', [
            'filters' => Request::all('search', 'trashed'),
            'expenses' => Auth::user()->account->dailyexpense()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'amount', 'note', 'created_at', 'deleted_at'),
        ]);
    }
}
