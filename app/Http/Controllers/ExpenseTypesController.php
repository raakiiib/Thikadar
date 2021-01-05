<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class ExpenseTypesController extends Controller
{
    public function index()
    {
        return Inertia::render('Suppliers/Index', [
            'filters' => Request::all('search', 'trashed'),
            'suppliers' => Auth::user()->account->suppliers()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(25)
                ->only('id', 'name', 'phone', 'city', 'deleted_at'),
        ]);
    }
}
