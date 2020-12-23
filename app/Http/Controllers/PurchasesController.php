<?php

namespace App\Http\Controllers;

use App\Models\Purchsase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PurchasesController extends Controller
{
    public function index()
    {
        return Inertia::render('Purchases/Index', [
            'filters' => Request::all('search', 'trashed'),
            'purchases' => Auth::user()->account->purchases()
                ->orderBy('number')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'number', 'supplier_id', 'material_id', 'deleted_at'),
        ]);
    }


    public function create()
    {
        return Inertia::render('Purchases/Create');
    }
}
