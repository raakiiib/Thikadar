<?php

namespace App\Http\Controllers;

// use App\Models\Supplier;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class ExpensesController extends Controller
{
    public function index()
    {
        return Inertia::render('Expenses/DailyExpIndex', [
            'filters' => Request::all('search', 'trashed'),
            'expenses' => Auth::user()->account->expenses()
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(25)
                ->transform( function ( $item ){

                    return [
                        'id' => $item->id,
                        'created_at' => date_format($item->created_at, 'd-m-Y'),
                        'invoice' => $item->invoice_number,
                        'name' => $item->name,
                        'type' => $item->expenseType->name,
                        'amount' => $item->net_amount,
                        'paid' => $item->paid_amount,
                        'due' => $item->due_amount,
                        'note' => $item->note,
                    ];

                })
        ]);
    }


    public function edit(Expense $expense)
    {
        
        return Inertia::render('Expenses/Edit', [
            'expense' => [
                'id' => $expense->id,
                'invoice_number' => $expense->invoice_number,
                'date' => date_format($expense->created_at, 'd-m-Y'),
                'expense_type' => $expense->expense_type,
                'name' => $expense->expenseType->name,
                'is_all_paid' => $expense->is_all_paid,
                'net_amount' => $expense->net_amount,
                'paid_amount' => $expense->paid_amount,
                'due_amount' => $expense->due_amount,
                'note' => $expense->note,               
            ],
        ]);
    }


    public function products()
    {          
        return Inertia::render('Expenses/ProductsIndex', [
            'filters' => Request::all('search', 'trashed'),
            'products' => Auth::user()->account->purchases()
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ( $product ){
                    return [
                        'id' => $product->id,
                        'invoice' => $product->invoice_number,
                        'quantity' => $product->quantity,
                        'unitprice' => $product->unitprice,
                        'total' => $product->net_amount,
                        'created_at' => $product->created_at,
                        'deleted_at' => $product->deleted_at,
                        'supplier' => $product->supplier
                            ->only('name'),
                        'material' => $product->material
                            ->only('name'),
                        'created_at' => date_format( $product->created_at, 'd-m-Y'),
                    ];                    
                })
        ]);
    }

    public function services()
    {
        return Inertia::render('Expenses/ServicesIndex', [
            'filters' => Request::all('search', 'trashed'),
            'services' => Auth::user()->account->purchase_services()
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($product){
                    return [
                        'id' => $product->id,
                        'invoice' => $product->invoice_number,
                        'quantity' => $product->quantity,
                        'unitprice' => $product->unitprice,
                        'total' => $product->net_amount,
                        'deleted_at' => $product->deleted_at,
                        'supplier' => $product->supplier
                            ->only('name'),
                        'material' => $product->service
                            ->only('name'),
                        'created_at' => date_format( $product->created_at, 'd-m-Y'),
                    ];                    
                }),
        ]);
    }

    public function dailyexpenses()
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

        return Inertia::render('Suppliers/Create');
    
    }

    

    public function destroy(Expense $expense)   
    {
        $expense->delete();

        return Redirect::back()->with('success', 'Entry removed.');
    }

    public function restore(Expense $expense)
    {
        $expense->restore();

        return Redirect::back()->with('success', 'Entry restored.');
    }
}
