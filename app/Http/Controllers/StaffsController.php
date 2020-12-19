<?php

namespace App\Http\Controllers;

use App\Models\Staffs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class StaffsController extends Controller
{
    public function index()
    {

        $staffs = [
            'filters' => Request::all('search'),
            'staffs' => Staffs::query()
                ->orderBy('id')
                ->filter(Request::only('search'))
                ->paginate()
                ->transform(function($staff){
                    return [
                        'id' => $staff->id,
                        'name' => $staff->name,
                        'phone' => $staff->phone,
                        'village' => $staff->village,
                        'district' => $staff->district,
                        'photo_path' => $staff->photoUrl(['w' => 70, 'h' => 70, 'fit' => 'crop']),
                        'deleted_at' => $staff->deleted_at
                    ];
                })
        ];
        return Inertia::render('Staffs/Index', $staffs);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staffs/Create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // Auth::user()->account->staffs()->create(
        // );
        
        Request::validate([
            'name' => ['required', 'max:100'],
            'date_of_birth' => ['date'],
            'national_id' => ['nullable', 'numeric', 'min:5'],
            'email' => ['nullable', 'max:50', 'email'],
            'phone' => ['nullable', 'max:50'],
            'address' => ['nullable', 'max:150'],
            'village' => ['nullable', 'max:50'],
            'district' => ['nullable', 'max:50'],
            'country' => ['nullable', 'max:2'],
            'salary' => ['nullable', 'numeric', 'min:3'],
            'postal_code' => ['nullable', 'max:25'],
            'photo_path' => ['nullable', 'image'],
        ]);

        Auth::user()->account->staffs()->create([
            'name' => Request::get('name'),
            'date_of_birth' => Request::get('date_of_birth'),
            'national_id' => Request::get('national_id'),
            'email' => Request::get('email'),
            'phone' => Request::get('phone'),
            'address' => Request::get('address'),
            'village' => Request::get('village'),
            'district' => Request::get('district'),
            'country' => Request::get('country'),
            'salary' => Request::get('salary'),
            'postal_code' => Request::get('postal_code'),
            'photo_path' => Request::file('photo_path') ? Request::file('photo_path')->store('staffs') : null,
        ]);

        return Redirect::route('staffs')->with('success', 'Staff created.');
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
