<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class ExpensesController extends Controller
{
    public function index()
    {

        return Inertia::render('Expenses/ProductsIndex', [
            'filters' => Request::all('search', 'trashed'),
            'products' => Auth::user()->account->purchases()
                ->orderBy('invoice_number')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($product){
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
                    ];                    
                }),
        ]);
    }

    public function products()
    {   

        
        return Inertia::render('Expenses/ProductsIndex', [
            'filters' => Request::all('search', 'trashed'),
            'products' => Auth::user()->account->purchases()
                ->orderBy('invoice_number')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($product){
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
                ->orderBy('invoice_number')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($product){
                    return [
                        'id' => $product->id,
                        'invoice' => $product->invoice_number,
                        'quantity' => $product->quantity,
                        'unitprice' => $product->unitprice,
                        'total' => $product->net_amount,
                        // 'created_at' => $product->created_at,
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
            'expenses' => Auth::user()->account->dailyexpense()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform( function ($expense){
                    return [
                        'id' => $expense->id,
                        'name' => $expense->name,
                        'amount' => $expense->amount,
                        'note' => $expense->note,
                        'type' => $expense->type,
                        'invoice' => $expense->invoice_number,
                        'created_at' => date_format( $expense->created_at, 'd-m-Y'),
                        // 'materials' => $expense->material
                        //     ->only('name', 'type')
                        // 'deleted_at' => date_format( $expense->deleted_at, 'd-m-Y'),

                    ];
                })
        ]);
    }

    public function create()
    {

        return Inertia::render('Suppliers/Create');
    
    }

    

    public function store()
    {
        Auth::user()->account->suppliers()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('suppliers')->with('success', 'Supplier created.');
    }


    public function editProduct(Supplier $supplier)
    {
        return Inertia::render('Suppliers/Edit', [
            'supplier' => [
                'id' => $supplier->id,
                'name' => $supplier->name,
                'email' => $supplier->email,
                'phone' => $supplier->phone,
                'address' => $supplier->address,
                'city' => $supplier->city,
                'region' => $supplier->region,
                'country' => $supplier->country,
                'postal_code' => $supplier->postal_code,
                'deleted_at' => $supplier->deleted_at,
                'contacts' => $supplier->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }


    public function update(Supplier $supplier)
    {
        $supplier->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return Redirect::back()->with('success', 'Supplier deleted.');
    }

    public function restore(Supplier $supplier)
    {
        $supplier->restore();

        return Redirect::back()->with('success', 'Supplier restored.');
    }
}