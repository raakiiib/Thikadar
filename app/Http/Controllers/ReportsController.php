<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function index()
    {
        return Inertia::render('Reports/Index', [
            'filters' => Request::all('search', 'trashed'),
            'suppliers' => Auth::user()->account->suppliers()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'phone', 'city', 'deleted_at'),
        ]);
    }


    public function suppliers()
    {
        return Inertia::render('Reports/Supplier', [
            'filters' => Request::all('search', 'trashed'),
            'suppliers' => Auth::user()->account->suppliers()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'phone', 'city', 'deleted_at'),
        ]);
    }


    public function products()
    {
        return Inertia::render('Reports/Product', [
            'filters' => Request::all('search', 'trashed'),
            'products' => Auth::user()->account->materials()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'type', 'description', 'unit'),
        ]);
    }


    public function showProductReport(Report $report)
    {
    	
    	dd($report);
    }
}

