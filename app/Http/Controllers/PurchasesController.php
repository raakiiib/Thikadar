<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
// use App\Models\RawMaterial;
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
            'products' => Auth::user()->account->purchases()
                // ->with('supplier')
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
                // ->only('id', 'invoice_number', 'quantity', 'unitprice', 'net_amount', 'deleted_at'),
        ]);
    }


    public function create()
    {
        return Inertia::render('Purchases/Create', [
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
                ->only('id', 'name'),
            'invoice_number' => $this->_generateInvoice(),
        ]);
    }

    public function store()
    {
        Auth::user()->account->purchases()->create(
            Request::validate([
                'material_id' => ['nullable'],
                'supplier_id' => ['nullable'],
                'invoice_number' => ['nullable', 'max:20'],
                'quantity' => ['nullable', 'max:10'],
                'unitprice' => ['nullable', 'max:10'],
                'net_amount' => ['nullable', 'max:10']
            ])
        );

        return Redirect::route('products')->with('success', 'Product purchased.');
    }

    protected function _generateInvoice()
    {
        $record = Auth::user()
            ->account
            ->purchases()
            ->first();

        if( !empty($record) ) {

            $invNum = explode('-', $record->invoice_number);
            if ( date('l',strtotime(date('Y-01-01'))) ){
                $invoiceNumber = date('ymd').'-0001';
            } else {
                $invoiceNumber = (($invNum[0]).'-'. ( $invNum[1] + 1 ));
            }

        }else{
            $invoiceNumber = date('ymd').'-00001';
        }

        return $invoiceNumber;
    }
}
