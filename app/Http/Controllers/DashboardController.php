<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        Auth::user()->account->expenses();
        $items= Expense::latest( 'created_at')->take(7)->get()
        ->transform( function ( $item ) {

            return [
                
                'created_at' => date_format($item->created_at, 'd-m-Y'),
                'paid' => $item->paid_amount,
                
            ];
            });


        return Inertia::render('Dashboard/Index', [
            "expenses7"=>$items,
            
        ]);
    }

    public function demo()
    {
        echo json_encode(['success' => 'message']);
    }
    
}
