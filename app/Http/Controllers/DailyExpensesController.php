<?php

namespace App\Http\Controllers;

use DB;
use App\Models\DailyExpense;
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
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(30)
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


    public function create()
    {
        return Inertia::render('Purchases/DailyExpense', [
            'invoice_number' => $this->_generateInvoice(),
            'expenses' => Auth::user()->account->expenseTypes()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(50)
                ->only('id', 'name', 'note', 'deleted_at'),
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


        // Start transaction!
        DB::beginTransaction();

        try {
            // Validate, then create if valid
            $expense = Auth::user()->account->expenses()->create([
                'expense_type' => 3, // type = 3
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
            // $newAcct = Account::create( ['accountname' => Input::get('accountname')] );
        } 
        catch(ValidationException $e){
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return Redirect::route('expenses.dailyexpense')
                ->withErrors( $e->getErrors() )
                ->withInput();
                // return Redirect::to('/form')

        } catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }

        try {

            $newPayment = Auth::user()->account->payments()->create([
                'expense_id' => $expense->id,
                'net_amount' => Request::get('net_amount'),
                'paid_amount' => Request::get('paid_amount'),
                // 'due_amount' => Request::get('due_amount'),
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

        return Redirect::route('expenses.dailyexpense')->with('success', 'Expense added.');
    }

    // editDailyExpenses
    public function edit(Expense $item)
    {
        dd($item);

        return Inertia::render('Expenses/Edit', [
            'expense' => [

                'id' => $item->id,
                'created_at' => date_format($item->created_at, 'd-m-Y'),
                'invoice' => $item->invoice_number,
                'name' => $item->name,
                // 'type' => $item->itemType->name,
                'amount' => $item->net_amount,
                'paid' => $item->paid_amount,
                'due' => $item->due_amount,
                'note' => $item->note,
            ],
        ]);
    }


    public function update(DailyExpense $expenses)
    {
        $expense->update(
            Request::validate([
                'paid_amount' => ['nullable', 'max:50'],
                'due_amount' => ['nullable', 'max:150'],
                'is_all_paid' => ['nullable', 'max:50'],
            ])
        );

        return Redirect::back()->with('success', 'Expense updated.');
    }

    public function destroy(DailyExpense $expense)
    {
        $expense->delete();

        return Redirect::back()->with('success', 'Expense deleted.');
    }

    public function restore(DailyExpense $expense)
    {
        $expense->restore();

        return Redirect::back()->with('success', 'Expense restored.');
    }

    protected function _generateInvoice()
    {
        $invoiceNumber = date('ymdhi');
        return $invoiceNumber;
    }
}
