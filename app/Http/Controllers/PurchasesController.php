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
                'created_at' => ['required'],
            ])
        );

        return Redirect::route('expenses.services')->with('success', 'Service purchased.');
    }


    public function getServiceDetail(Service $service)
    {
        $data = [
            'service' => $service,
        ];

        return $data;
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
