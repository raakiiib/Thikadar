<?php

namespace App\Http\Controllers;

use App\Models\Purchsase;
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
                ->orderBy('number')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'number', 'supplier_id', 'material_id', 'deleted_at'),
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
            'invoice_number' => $this->generateInvoice(),
        ]);
    }

    public function generateInvoice()
    {
        // return 'INV001';
        //IT SHOULD BE INSIDE YOUR MEHTOD

        //get last record
        $record = Auth::user()
            ->account
            ->purchases()
            ->first();

        if( !empty($record) ) {

            $invNum = explode('-', $record->invoice_number);
            //check first day in a year
            if ( date('l',strtotime(date('Y-01-01'))) ){
                $invoiceNumber = date('Y').'-0001';
            } else {
                //increase 1 with last invoice number
                $invoiceNumber = $invNum[0].'-'. ( $invNum[1] )+1;
            }

        }
        else return '0';


        exit();
        $expNum = explode('-', $record->invoiceno);


        

    }
}
