<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Expense;
use App\Models\RawMaterial;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class ProductsController extends Controller
{

    public function index()
    {
    	return Inertia::render('Expenses/ProductsIndex', [
            'filters' => Request::all('search', 'trashed'),
            'products' => Auth::user()->account->expenses()
            	->where('expense_type', 1)
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(25)
                ->transform(function ( $product ){
                    return [
                        'id' => $product->id,
                        'invoice' => $product->invoice_number,
                        'quantity' => $product->quantity,
                        'unitprice' => $product->unit_price,
                        'total' => $product->net_amount,
                        'due' => $product->due_amount,
                        'is_all_paid' => $product->is_all_paid,
                        'product_id' => $product->product_id,
                        'vendor_id' => $product->vendor_id,
                        'created_at' => $product->created_at,
                        'deleted_at' => $product->deleted_at,
                        'supplier' => $product->getSupplier->name,
                        'material' => $product->getMaterial->name,
                        'unit' => $product->getMaterial->unit,
                        'created_at' => date_format( $product->created_at, 'd-m-Y'),
                    ];                    
                })
        ]);
    }

    public function create()
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
            'pay_types' => Auth::user()->account->cost_types()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name'),
            'invoice_number' => $this->_generateInvoice(),
        ]);
    }

    public function store()
    {
        Request::validate([
            'created_at' => ['required'],
            'invoice_number' => ['required', 'max:30'],
            'unitprice' => ['required', 'max:10'],
            'quantity' => ['required', 'max:10'],
            'net_amount' => ['required', 'max:10'],
            'paid_amount' => ['required', 'max:10'],
            'due_amount' => ['required', 'max:10'],
            'product_id' => ['required'],
            'vendor_id' => ['required'],
            'note' => ['max:300'],
        ]);

        // Start transaction!
        DB::beginTransaction();
        try {
            // Validate, then create if valid
            $expense = Auth::user()->account->expenses()->create([
                'invoice_number' => Request::get('invoice_number'),
                'created_at' => Request::get('created_at'),
                'expense_type' => Request::get('expense_type'),
                'vendor_id' => Request::get('vendor_id'),
                'product_id' => Request::get('product_id'),
                'unit_price' => Request::get('unitprice'),
                'quantity' => Request::get('quantity'),
                'net_amount' => Request::get('net_amount'),
                'paid_amount' => Request::get('paid_amount'),
                'due_amount' => Request::get('due_amount'),
                'is_all_paid' => Request::get('is_all_paid') ,
                'note' => Request::get('note'),
                'photo_path' => Request::file('photo_path') ? Request::file('photo_path')->store('expneses') : null,
            ]);
        } 
        catch(ValidationException $e){
            DB::rollback();
            return Redirect::route('expenses.dailyexpense')
                ->withErrors( $e->getErrors() )
                ->withInput();
        } catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }

        try {
            $newPayment = Auth::user()->account->payments()->create([
                'expense_id' => $expense->id,
                'net_amount' => Request::get('net_amount'),
                'payment_type' => Request::get('pay_type'),
                'paid_amount' => Request::get('paid_amount'),
                'is_all_paid' => Request::get('is_all_paid'),
                'note' => Request::get('note'),
                'created_at' => Request::get('created_at'),
            ]);
        } catch(ValidationException $e){
            DB::rollback();
            return Redirect::route('expenses.dailyexpense')
                ->withErrors( $e->getErrors() )
                ->withInput();
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return Redirect::route('expenses.products')->with('success', 'Expense added.');
    }

    public function show(RawMaterial $product)
    {
        $data = Inertia::render('Products/Single', [
            'products' => [
                'id' => $product->id,
                'name' => $product->name,
                'note' => $product->note,
                'deleted_at' => $product->deleted_at,
                'expenses' => $product->material_expenses()->where('expense_type', 1)->get()->map->only([
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

        return $data;
    }


    public function show_vendor(Supplier $vendor)
    {
        $data = Inertia::render('Expenses/VendorSingle', [
            'vendor' => [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'phone' => $vendor->phone,
                'deleted_at' => $vendor->deleted_at,
                'expenses' => $vendor->vendor_expenses()->where('expense_type', 1)->get()->map->only([
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

        return $data;
    }

    public function edit(Expense $product)
    {
        
        return Inertia::render('Products/Edit', [
            'expense' => [
            	'id' => $product->id,
                'invoice_number' => $product->invoice_number,
                'quantity' => $product->quantity,
                'unit_price' => $product->unit_price,
                'net_amount' => $product->net_amount,
                'date' => $product->created_at,
                'expense_type' => $product->expense_type,
                'paid_amount' => $product->paid_amount,
                'due_amount' => $product->due_amount,
                'deleted_at' => $product->deleted_at,
                'product_name' => $product->getMaterial->name,
                'product_type' => $product->getMaterial->type,
                'product_unit' => $product->getMaterial->unit,
                'supplier' => $product->getSupplier->name,
                'is_all_paid' => $product->is_all_paid,
                'created_at' => date_format( $product->created_at, 'd-m-Y'),
                'payments' => $product->payments()->get()->map->only([
                    'id', 
                    'paid_amount',
                    'payment_type',
                    'note', 
                    'created_at',
                ]),
            ],
            'pay_types' => Auth::user()->account->cost_types()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name'),
        ]);
    }

    public function update(Expense $product)
    {
        // dd($expense);
        Request::validate([
            'net_amount' => ['required', 'max:10'],
            'paid_amount' => ['required', 'max:10'],
            'due_amount' => ['required', 'max:10'],
        ]);

        DB::beginTransaction();

        // Add new payment
        try {
            $product->update([
                'paid_amount' => Request::get('total_paid'),
                'due_amount' => Request::get('due_amount'),
                'is_all_paid' => Request::get('is_all_paid') ,
            ]);

            $payment = Auth::user()->account->payments()->create([
                'expense_id' => Request::get('expense_id'), // type = 3
                'net_amount' => Request::get('net_amount'),
                'payment_type' => Request::get('pay_type'),
                'paid_amount' => Request::get('paid_amount'),
                'note' => Request::get('note'),
                'created_at' => Request::get('created_at'),
                'is_all_paid' => Request::get('is_all_paid') ,
            ]);
        } 
        catch(ValidationException $e){
            DB::rollback();
            return Redirect::route('expenses.dailyexpense')
                ->withErrors( $e->getErrors() )
                ->withInput();
        }
        catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();
        return Redirect::back()->with('success', 'Payment recorded.');
    }

    public function destroy(Expense $expense)   
    {
        $expense->delete();
        return Redirect::route('expenses.products')->with('success', 'Entry removed.');
    }

    public function restore(Expense $expense)
    {
        $expense->restore();
        return Redirect::back()->with('success', 'Entry restored.');
    }

    protected function _generateInvoice()
    {
        $invoiceNumber = date('ymdhi');
        return $invoiceNumber;
    }
}
