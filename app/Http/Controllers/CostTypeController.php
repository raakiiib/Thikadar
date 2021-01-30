<?php

namespace App\Http\Controllers;

use App\Models\CostType;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class CostTypeController extends Controller
{
    public function index()
    {
        return Inertia::render('CostTypes/Index', [
            'filters' => Request::all('search', 'trashed'),
            'costs' => Auth::user()->account->cost_types()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name', 'note', 'deleted_at'),
        ]);
    }


    public function create()
    {

        return Inertia::render('CostTypes/Create');
    
    }
    
    public function store()
    {
        Auth::user()->account->cost_types()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'note' => ['nullable', 'max:150'],
            ])
        );

        return Redirect::route('costs')->with('success', 'Type added.');
    }

    public function edit(CostType $expense)
    {
        return Inertia::render('CostTypes/Edit', [
            'type' => [
                'id' => $expense->id,
                'name' => $expense->name,
                'note' => $expense->note,
                'deleted_at' => $expense->deleted_at,
                'expenses' => $expense->expenses()->where('expense_type', 3)->get()->map->only([
                    'id',
                    'invoice_number',
                    'net_amount',
                    'paid_amount', 
                    'due_amount',
                    'note', 
                    'created_at',
                ]),
            ],
        ]);
    }

    public function update(CostType $type)
    {
        $type->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'note' => ['nullable', 'max:150']
            ])
        );

        return Redirect::back()->with('success', 'Type updated.');
    }

    public function destroy(CostType $type)
    {
        $type->delete();

        return Redirect::back()->with('success', 'Type deleted.');
    }

    public function restore(CostType $type)
    {
        $type->restore();
        return Redirect::back()->with('success', 'Type restored.');
    }

}
