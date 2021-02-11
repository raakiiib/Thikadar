<?php


namespace App\Http\Controllers;

use DB;
use App\Models\Expense;
use App\Models\Supplier;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class BlockDumpingController extends Controller
{

    public function index()
    {
        $data = Auth::user()->account->expenses()
                ->where('expense_type', 4)
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(25)
                ->transform(function ($service){
                    return [
                        'id' => $service->id,
                        'quantity' => $service->quantity,
                        'unitprice' => $service->unitprice,
                        'total' => $service->net_amount,
                        'due' => $service->due_amount,
                        'size' => $service->size,
                        'unitprice' => $service->unit_price,
                        'deleted_at' => $service->deleted_at,
                        'service_id' => $service->product_id,
                        'supplier_id' => $service->vendor_id,
                        'supplier' => $service->getSupplier->name,
                        'product' => $service->getService->name,
                        'product_size' => $service->getService->dimension,
                        'created_at' => date_format( $service->created_at, 'd-m-Y'),
                    ];                    
                });

        return Inertia::render('Dumping/Index', [
            'filters' => Request::all('search', 'trashed'),
            'services' => $data,
        ]);
    }

    public function create()
    {
        return Inertia::render('Dumping/Create', [
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
                ->only('id', 'name', 'dimension', 'size', 'unit'),
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
            'product_id' => ['required'],
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
                'product_id'        => Request::get('product_id'),
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
            return Redirect::route('expenses.service')
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
            return Redirect::route('expenses.service')
                ->withErrors( $e->getErrors() )
                ->withInput();
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return Redirect::route('dumping.index')->with('success', 'ব্লক কাস্টিং যোগ হয়েছে.');
    }


    public function edit(Expense $service)
    {
        return Inertia::render('Expenses/ServiceExpensesEdit', [
            'expense' => [
                'id' => $service->id,
                'invoice_number' => $service->invoice_number,
                'quantity' => $service->quantity,
                'unit_price' => $service->unit_price,
                'net_amount' => $service->net_amount,
                'date' => $service->created_at,
                'expense_type' => $service->expense_type,
                'paid_amount' => $service->paid_amount,
                'due_amount' => $service->due_amount,
                'deleted_at' => $service->deleted_at,
                'service' => $service->getService->name,
                'supplier' => $service->getSupplier->name,
                'is_all_paid' => $service->is_all_paid,
                'created_at' => date_format( $service->created_at, 'd-m-Y'),
                'payments' => $service->payments()->get()->map->only([
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


    public function update(Expense $service)
    {
        Request::validate([
            'net_amount' => ['required', 'max:10'],
            'paid_amount' => ['required', 'max:10'],
            'due_amount' => ['required', 'max:10'],
        ]);

        DB::beginTransaction();

        // Add new payment
        try {
            $service->update([
                'paid_amount' => Request::get('total_paid'),
                'due_amount' => Request::get('due_amount'),
                'is_all_paid' => Request::get('is_all_paid') ,
            ]);

            $payment = Auth::user()->account->payments()->create([
                'expense_id' => Request::get('expense_id'),
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
        // return Redirect::back()->with('success', 'ব্লক কাস্টিং হালনাগাদ হয়েছে');
        return Redirect::route('expenses.services')->with('success', 'ব্লক কাস্টিং হালনাগাদ হয়েছে.');
        
    }

    public function show(Service $service)
    {
        $data = Inertia::render('Dumping/BlockSingle', [
            'products' => [
                'id' => $service->id,
                'name' => $service->name,
                'note' => $service->note,
                'deleted_at' => $service->deleted_at,
                'dimension' => $service->dimension,
                'expenses' => $service->service_expenses()
                    ->where('expense_type', 4)
                    ->get()
                    ->map
                    ->only([
                        'id',
                        'invoice_number',
                        'net_amount',
                        'paid_amount', 
                        'due_amount',
                        'quantity',
                        'size',
                        'note', 
                        'created_at',
                    ]),
            ],
        ]);

        return $data;
    }


    public function vendor(Supplier $vendor)
    {
        $data = Inertia::render('Dumping/VendorSingle', [
            'vendor' => [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'phone' => $vendor->phone,
                'deleted_at' => $vendor->deleted_at,
                'expenses' => $vendor->vendor_expenses()
                    ->where('expense_type', 4)
                    ->get()
                    ->map
                    // ->groupBy('created_at')
                    ->only([
                        'id',
                        'invoice_number',
                        'net_amount',
                        'paid_amount',
                        'due_amount',
                        'quantity',
                        'size',
                        'note', 
                        'created_at',
                    ]),
            ],
        ]);

        return $data;
    }

    public function get_service_single(Service $service)
    {
        $data = [
            'service' => $service,
        ];
        return $data;
    }


    protected function _generateInvoice()
    {
        $invoiceNumber = date('ymdhi');
        return $invoiceNumber;
    }
}
