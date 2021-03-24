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
    public function index()
    {
        ;
            return Inertia::render('Dashboard/Index', [
                "expenses7"=>$this->putData(7),
                "expenses30"=>$this->putData(30),
             
                
            ]);

        
    }

    

    public function demo()
    {
        echo json_encode(['success' => 'message']);
    }
    
}
