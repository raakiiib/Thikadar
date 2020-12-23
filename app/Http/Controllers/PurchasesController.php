<?php

namespace App\Http\Controllers;

use App\Models\Purchsases;
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
            'materials' => Auth::user()->account->materials()
                ->orderBy('product_name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'product_name', 'unit', 'description', 'deleted_at'),
        ]);

    }
}
