<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class PurchasesController extends Controller
{

    public function index()
    {

        dd('here i am');
        return Inertia::render('Purchases/Index', [
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


    public function createProduct()
    {
        return Inertia::render('Purchases/Product', [
            'suppliers' => Auth::user()->account
                ->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'products' => Auth::user()->account
                ->materials()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name', 'type'),
            'invoice_number' => $this->_generateInvoice(),
        ]);
    }

    public function createDailyExpenses()
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

    public function editProduct(Purchases $purchase)
    {
        return Inertia::render('Purchases/EditProduct', [
            'purchases' => [
                'id' => $purchase->id,
                'supplier_id' => '',
                'material_id' => '',
                'invoice_number' => $purchase->invoice_number,
                'quantity' => $supplier->email,
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


    public function createServices()
    {
        return Inertia::render('Purchases/Service', [
            'suppliers' => Auth::user()->account
                ->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'services' => Auth::user()->account
                ->services()
                ->orderBy('id')
                ->get()
                ->map
                ->only('id', 'name', 'size', 'unit', 'convert_to'),
            'invoice_number' => $this->_generateInvoice(),
        ]);
    }

    // Store product data
    public function store()
    {
        Auth::user()->account->purchases()->create(
            Request::validate([
                'material_id' => ['required'],
                'supplier_id' => ['required'],
                'invoice_number' => ['required', 'max:20'],
                'quantity' => ['required', 'max:10'],
                'unitprice' => ['required', 'max:10'],
                'net_amount' => ['required', 'max:10'],
                'paid_amount' => ['required', 'max:10'],
                'due_amount' => ['required', 'max:10'],
                'is_all_paid' => ['boolean'],
                'created_at' => ['required'],
            ])
        );

        return Redirect::route('expenses.products')->with('success', 'Product purchased.');
    }


    public function storeService()
    {
        Auth::user()->account->purchase_services()->create(
            Request::validate([
                'service_id' => ['required'],
                'supplier_id' => ['required'],
                'invoice_number' => ['required', 'max:20'],
                'quantity' => ['required', 'max:10'],
                'size' => ['required', 'max:10'],
                'unitprice' => ['required', 'max:10'],
                'net_amount' => ['required', 'max:10'],
                'paid_amount' => ['required', 'max:10'],
                'due_amount' => ['required', 'max:10'],
                'is_all_paid' => ['boolean'],
                'created_at' => ['required'],
            ])
        );

        return Redirect::route('expenses.services')->with('success', 'Service purchased.');
    }

    public function storeExpense()
    {
        Auth::user()->account->expenses()->create(
            Request::validate([
                'name' => ['max: 100'],
                // 'material_id' => ['required'],
                'net_amount' => ['required', 'max:10'],
                'paid_amount' => ['max:10'],
                'due_amount' => ['required', 'max:10'],
                'is_all_paid' => ['boolean'],
                'note' => ['max:300'],
                'invoice_number' => ['required', 'max:30'],
                'created_at' => ['required'],
            ])
        );

        return Redirect::route('expenses.dailyexpense')->with('success', 'Expense added.');
    }


    public function getServiceDetail(Service $service)
    {
        $data = [
            'service' => $service,
        ];

        return $data;
    }

    public function getMaterial(RawMaterial $product)
    {
        $data = [
            'service' => $product,
        ];

        return $data;
    }

    protected function _generateInvoice()
    {
        $invoiceNumber = date('ymdhi');
        return $invoiceNumber;
    }
}
