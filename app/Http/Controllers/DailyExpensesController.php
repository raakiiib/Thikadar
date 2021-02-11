<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Expense;
use App\Models\CostType;
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
                ->where('expense_type', 3)
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(25)
                ->transform( function ( $item ) {

                    return [
                        'id' => $item->id,
                        'created_at' => date_format($item->created_at, 'd-m-Y'),
                        'invoice' => $item->invoice_number,
                        'exp_type_id' => $item->product_id,
                        'type' => $item->getCosts->name,
                        'amount' => $item->net_amount,
                        'paid' => $item->paid_amount,
                        'due' => $item->due_amount,
                        'note' => $item->note,
                        'deleted_at' => $item->deleted_at,
                    ];

                })
        ]);
    }


    public function create()
    {
        return Inertia::render('Purchases/DailyExpense', [
            'invoice_number' => $this->_generateInvoice(),
            'suppliers' => Auth::user()->account
                ->suppliers()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'expenses' => Auth::user()->account->beneficiary()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name', 'note', 'deleted_at'),
            'costs' => Auth::user()->account->cost_types()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name',)
        ]);
    }


    public function store()
    {
        Request::validate([
            'product_id' => ['required'],
            'note' => ['max:300'],
            'invoice_number' => ['required', 'max:30'],
            'created_at' => ['required'],
            'net_amount' => ['required', 'max:10'],
            'paid_amount' => ['required', 'max:10'],
            'due_amount' => ['required', 'max:10'],
        ]);
        
        DB::beginTransaction();

        try {
            $expense = Auth::user()->account->expenses()->create([
                'expense_type' => 3, // type = 3
                'vendor_id' => Request::get('vendor_id'),
                'product_id' => Request::get('product_id'),
                'note' => Request::get('note'),
                'invoice_number' => Request::get('invoice_number'),
                'created_at' => Request::get('created_at'),
                'net_amount' => Request::get('net_amount'),
                'paid_amount' => Request::get('paid_amount'),
                'due_amount' => Request::get('due_amount'),
                'is_all_paid' => Request::get('is_all_paid') ,
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
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return Redirect::route('expenses.dailyexpense')
                ->withErrors( $e->getErrors() )
                ->withInput();
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return Redirect::route('expenses.dailyexpense')->with('success', 'খরচ যোগ হয়েছে');
    }

    public function edit(Expense $expense)
    {
        
        return Inertia::render('Expenses/Edit', [
            'expense' => [
                'id' => $expense->id,
                'invoice_number' => $expense->invoice_number,
                'date' => date_format($expense->created_at, 'd-m-Y'),
                'expense_type' => $expense->expense_type,
                'name' => $expense->getCosts->name,
                // 'supplier' => $expense->getSupplier->name,
                // 'payment_type' => $expense->
                'is_all_paid' => $expense->is_all_paid,
                'net_amount' => $expense->net_amount,
                'paid_amount' => $expense->paid_amount,
                'due_amount' => $expense->due_amount,
                'note' => $expense->note,
                'deleted_at' => $expense->deleted_at,
                'payments' => $expense->payments()->get()->map->only([
                    'id', 
                    'paid_amount',
                    'payment_type',
                    'note', 
                    'created_at',
                ]),
            ],
            'costs' => Auth::user()->account->cost_types()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name',)
        ]);
    }


    public function update(Expense $expense)
    {
        // dd($expense);
        Request::validate([
            'net_amount' => ['required', 'max:10'],
            'paid_amount' => ['required', 'max:10'],
            'due_amount' => ['required', 'max:10'],
        ]);
        // numeric|min:2|max:5

        DB::beginTransaction();

        // Add new payment
        try {
            $expense->update([
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
        // return Redirect::route('expenses.dailyexpense')->with('success', 'Payment recorded.');
        return Redirect::route('expenses.dailyexpense')->with('success', 'বাকি পরিষোধ হয়েছে');
    }


    public function destroy(Expense $expense)   
    {
        $expense->delete();

        return Redirect::route('expenses.dailyexpense')->with('success', 'Entry removed.');
        // return Redirect::back()->with('success', 'Entry removed.');
    }

    public function restore(Expense $expense)
    {
        $expense->restore();

        return Redirect::back()->with('success', 'Entry restored.');
    }

    public function show(CostType $expense)
    {
        return Inertia::render('DailyExpenses/Single', [
            'type' => [
                'id' => $expense->id,
                'name' => $expense->name,
                'note' => $expense->note,
                'deleted_at' => $expense->deleted_at,
                'expenses' => $expense->expenses()->where('expense_type', 3)->get()->map->only([
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
    }

    protected function _generateInvoice()
    {
        $invoiceNumber = date('ymdhi');
        return $invoiceNumber;
    }
}
