<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class StaffsController extends Controller
{
    public function index()
    {
     
        $staffs =Staff::query();

        return Inertia::render('Staffs/Index', [
            'filters' => Request::all('search'),
            'staffs' => Staff::query()
                ->orderBy('id')
                ->filter(Request::only('search'))
                ->paginate()
                ->only('id', 'name', 'phone', 'district'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staffs  $staffs
     * @return \Illuminate\Http\Response
     */
    public function show(Staffs $staffs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staffs  $staffs
     * @return \Illuminate\Http\Response
     */
    public function edit(Staffs $staffs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staffs  $staffs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staffs $staffs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staffs  $staffs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staffs $staffs)
    {
        //
    }
}
