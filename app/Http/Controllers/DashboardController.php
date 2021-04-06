<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function putData($item){


      
        return Expense::latest( 'created_at')->take($item)->get()
        ->transform( function ( $expense ) {

                return [
                
                    'created_at' => date_format($expense->created_at, 'd-m-Y'),
                    'paid' => $expense->paid_amount,
         
                ];
        });
        
    }

    /**
     * 
     */
    public function putDataProduct($item){
      
        return Expense::latest( 'created_at')->where('expense_type', 1)->
        take($item)->get()
        ->transform( function ( $expense ) {

                return [
                
                    'created_at' => date_format($expense->created_at, 'd-m-Y'),
                    'paid' => $expense->paid_amount,
         
                ];
        });
        
    }

    public function putDataBlockDumping($item){
      
        return Expense::latest( 'created_at')->where('expense_type', 4)->
        take($item)->get()
        ->transform( function ( $expense ) {

                return [
                
                    'created_at' => date_format($expense->created_at, 'd-m-Y'),
                    'paid' => $expense->paid_amount,
         
                ];
        });
        
    }
    public function putDataBlock($item){
      
        return Expense::latest( 'created_at')->where('expense_type', 2)->
        take($item)->get()
        ->transform( function ( $expense ) {

                return [
                
                    'created_at' => date_format($expense->created_at, 'd-m-Y'),
                    'paid' => $expense->paid_amount,
         
                ];
        });
        
    }
    public function putDataGoBag($item){
      
        return Expense::latest( 'created_at')->where('expense_type', 5)->
        take($item)->get()
        ->transform( function ( $expense ) {

                return [
                
                    'created_at' => date_format($expense->created_at, 'd-m-Y'),
                    'paid' => $expense->paid_amount,
         
                ];
        });
        
    }
    public function index()
    {
        ;
            return Inertia::render('Dashboard/Index', [
                "expenses7"=>$this->putData(7),
                "expenses30"=>$this->putData(30),
                "expenses7Product"=>$this->putDataProduct(7),
                "expenses30Product"=>$this->putDataProduct(30),
                "blockDumping7"=>$this->putDataBlockDumping(7),
                "blockDumping30"=>$this->putDataBlockDumping(30),
                "block7"=>$this->putDataBlock(7),
                "block30"=>$this->putDataBlock(30),
                "gobagexpenses30"=>$this->putDataGoBag(30),

             
                
            ]);

        
    }

    

    public function demo()
    {
        echo json_encode(['success' => 'message']);
    }
    
}
