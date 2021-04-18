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
    public function getAllExpense(){
        $item =30;
        
        $data=Expense::latest( 'created_at')->
        take($item)->get()
        ->transform( function ( $expense ) {

            return [
            
                'created_at' => date_format($expense->created_at, 'd-m-Y'),
                  'paid'=> $expense->paid_amount,
                  'expense_type'=>$expense->expense_type,
                
     
                 ];
                });
                             $total = 0;
                             $expenseType = [];
                 foreach($data as $d) {
                    if(isset($expenseType[$d['expense_type']])) {
                        $expenseType[$d['expense_type']]+=$d['paid'];
                    } else {
                        $expenseType[$d['expense_type']]=$d['paid'];
                    }
                    $total+=$d['paid'];
                 }

                 $graphData = [];
                 $i = 0;
                 foreach($expenseType as $k=>$v) {
                     if($k ==1)
                     {
                         $k="PRODUCT BUY";
                     }
                     else if ($k==2)
                     {
                        $k="BLOCK CASTING";
                     }else if ($k==3)
                     {
                        $k="DAILY COST";
                     }else if($k==4)
                     {
                        $k="BLOCK DUMPING";
                     }else if($k==5 )
                      {
                        $k="GO BAG";
                     }
                    $percent = $v*100/$total;
                    $graphData[$i]=[
                       
                        'label' => $k." (".round($percent,2)."%".")",
                        'value' => $percent,
                        'total' => $v

                    ];
                    $i++;
                   
                 }

                        return $graphData; 

        
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
                'donutChartalData'=>$this->getAllExpense(),

             
                
            ]);

        
    }

    

    public function demo()
    {
        echo json_encode(['success' => 'message']);
    }
    
}
