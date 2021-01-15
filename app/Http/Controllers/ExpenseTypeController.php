<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class ExpenseTypeController extends Controller
{
    public function index()
    {
        return Inertia::render('ExpenseTypes/Index', [
            'filters' => Request::all('search', 'trashed'),
            'exptypes' => Auth::user()->account->expenseTypes()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name', 'note', 'deleted_at'),
        ]);
    }


    public function create()
    {

        return Inertia::render('ExpenseTypes/Create');
    
    }
    
    public function store()
    {
        Auth::user()->account->ExpenseTypes()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'note' => ['nullable', 'max:150'],
            ])
        );

        return Redirect::route('exptypes')->with('success', 'Type added.');
    }

    public function edit(ExpenseType $expense)
    {
        return Inertia::render('ExpenseTypes/Edit', [
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

    public function update(ExpenseType $type)
    {
        $type->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'note' => ['nullable', 'max:150']
            ])
        );

        return Redirect::back()->with('success', 'Type updated.');
    }

    public function destroy(ExpenseType $type)
    {
        $type->delete();

        return Redirect::back()->with('success', 'Type deleted.');
    }

    public function restore(ExpenseType $type)
    {
        $type->restore();
        return Redirect::back()->with('success', 'Type restored.');
    }

}
