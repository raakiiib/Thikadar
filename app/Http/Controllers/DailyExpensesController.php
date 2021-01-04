<?php

namespace App\Http\Controllers;

use App\Models\DailyExpense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class DailyExpensesController extends Controller
{


    public function index()
    {
        return Inertia::render('Expenses/DailyExpIndex', [
            'filters' => Request::all('search', 'trashed'),
            'expenses' => Auth::user()->account->expenses()
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform( function ( $expenses ){

                    return [
                        'created_at' => date_format($expenses->created_at, 'd-m-Y'),
                        'id' => $expenses->id,
                        'invoice' => $expenses->invoice_number,
                        'name' => $expenses->name,
                        'type' => $expenses->material_id,
                        'amount' => $expenses->net_amount,
                        'paid' => $expenses->paid_amount,
                        'due' => $expenses->due_amount,
                        'note' => $expenses->note,
                    ];

                })
        ]);
    }


    public function create()
    {
        return Inertia::render('Purchases/DailyExpense', [
            'invoice_number' => $this->_generateInvoice(),
            'products' => Auth::user()->account
                ->materials()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name', 'type')
        ]);
    }


    public function store()
    {
        Auth::user()->account->expenses()->create(
            Request::validate([
                'name' => ['required', 'max: 100'],
                'net_amount' => ['required', 'max:10'],
                'paid_amount' => ['required', 'max:10'],
                'due_amount' => ['required', 'max:10'],
                'is_all_paid' => ['boolean'],
                'note' => ['max:300'],
                'invoice_number' => ['required', 'max:30'],
                'created_at' => ['required'],
            ])
        );

        return Redirect::route('expenses.dailyexpense')->with('success', 'Expense added.');
    }

    // editDailyExpenses
    public function edit(DailyExpense $expense)
    {
        // dd($supplier);
        return Inertia::render('Expenses/Edit', [
            'expense' => [
                'id' => $expense->id,
                'invoice_number' => $expense->invoice_number,
                'name' => $expense->name,
                'note' => $expense->note,
                'net_amount' => $expense->net_amount,
                'paid_amount' => $expense->paid_amount,
                'due_amount' => $expense->due_amount,
                'is_all_paid' => $expense->is_all_paid,
                'created_at' => date_format($expense->created_at, 'd-m-Y'),
                'deleted_at' => $expense->deleted_at,
            ],
        ]);
    }

    public function destroy(DailyExpense $expense)
    {
        $expense->delete();

        return Redirect::back()->with('success', 'Expense deleted.');
    }

    public function restore(DailyExpense $expense)
    {
        $expense->restore();

        return Redirect::back()->with('success', 'Expense restored.');
    }

    protected function _generateInvoice()
    {
        $invoiceNumber = date('ymdhi');
        return $invoiceNumber;
    }
}
