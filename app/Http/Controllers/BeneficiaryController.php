<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class BeneficiaryController extends Controller
{
    public function index()
    {
        return Inertia::render('Beneficiary/Index', [
            'filters' => Request::all('search', 'trashed'),
            'beneficiary' => Auth::user()->account->beneficiary()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name', 'note', 'deleted_at'),
        ]);
    }


    public function create()
    {

        return Inertia::render('Beneficiary/Create');
    
    }
    
    public function store()
    {
        Auth::user()->account->beneficiary()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'note' => ['nullable', 'max:150'],
            ])
        );

        return Redirect::route('beneficiary')->with('success', 'Type added.');
    }

    public function edit(Beneficiary $expense)
    {
        return Inertia::render('Beneficiary/Edit', [
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

    public function update(Beneficiary $type)
    {
        $type->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'note' => ['nullable', 'max:150']
            ])
        );

        return Redirect::back()->with('success', 'Type updated.');
    }

    public function destroy(Beneficiary $type)
    {
        $type->delete();

        return Redirect::back()->with('success', 'Type deleted.');
    }

    public function restore(Beneficiary $type)
    {
        $type->restore();
        return Redirect::back()->with('success', 'Type restored.');
    }

}
