<?php

namespace App\Http\Controllers;
use DB;
use Request;
use App\Models\Expense;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GoBagController extends Controller
{
    public function index()
    {
        $data = Auth::user()->account->expenses()
        ->where('expense_type', 5)
        ->orderBy('created_at', 'DESC')
        ->filter(Request::only('search', 'trashed'))
        ->paginate(25)
        ->transform(function ($service){
            return [
                'id' => $service->id,
                'quantity' => $service->quantity,
                'unitprice' => $service->unitprice,
                'total' => $service->net_amount,
                'paid' => $service->paid_amount,
                'due' => $service->due_amount,
                'size' => $service->size,
                'unitprice' => $service->unit_price,
                'deleted_at' => $service->deleted_at,
                'supplier_id' => $service->vendor_id,
                'supplier' => $service->getSupplier->name,
                'created_at' => date_format( $service->created_at, 'd-m-Y'),
            ];                    
        });
        
        return Inertia::render('GoBag/Index', [
            'filters' => Request::all('search', 'trashed'),
            'services' => $data,
    
]);
    }

    
    public function create()
    {
        return Inertia::render('GoBag/Create', [
            'suppliers' => Auth::user()->account
                ->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'pay_types' => Auth::user()->account->cost_types()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name'),
            'invoice_number' => $this->_generateInvoice(),
            
        ]);
    }

    public function store(Request $request)
    {
        Request::validate([
            'created_at' => ['required'],
            'vendor_id' => ['required'],
            'unitprice' => ['required', 'max:10'],
            'quantity' => ['required', 'max:10'],
            'net_amount' => ['required', 'max:10'],
            'paid_amount' => ['required', 'max:10'],
            'due_amount' => ['required', 'max:10'],
            'note' => ['max:300'],
        ]);

        // Start transaction!
        DB::beginTransaction();
        try {
            $expense = Auth::user()->account->expenses()->create([
                'invoice_number'    => Request::get('invoice_number'),
                'created_at'        => Request::get('created_at'),
                'expense_type'      => Request::get('expense_type'),
                'vendor_id'         => Request::get('vendor_id'),
                'quantity'          => Request::get('quantity'),
                'unit_price'        => Request::get('unitprice'),
                'size'              => Request::get('size'),
                'net_amount'        => Request::get('net_amount'),
                'paid_amount'       => Request::get('paid_amount'),
                'due_amount'        => Request::get('due_amount'),
                'is_all_paid'       => Request::get('is_all_paid') ,
                'note'              => Request::get('note'),
            ]);
        } 
        catch(ValidationException $e){
            DB::rollback();
            return Redirect::route('gobag.index')
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
            return Redirect::route('gobag.index')
                ->withErrors( $e->getErrors() )
                ->withInput();
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return Redirect::route('gobag.index')->with('success', 'go bag যোগ হয়েছে.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    protected function _generateInvoice()
    {
        $invoiceNumber = date('ymdhi');
        return $invoiceNumber;
    }
}
