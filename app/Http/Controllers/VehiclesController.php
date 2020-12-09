<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'filters' => Request::all('search', 'trashed'),
            'vehicles' => Auth::user()->account->vehicles()
                ->orderBy('driver_name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id',  'driver_name', 'driver_phone', 'chassis_number', 'registration_number', 'description', 'deleted_at')
        ];

        return Inertia::render('Vehicles/Index', $data);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Vehicles/Create');
    }

    
    public function store(Request $request)
    {
        Auth::user()->account->vehicles()->create(
            Request::validate([
                'driver_name' => ['required', 'max:50'],
                'driver_phone' => ['required', 'max:25'],
                'chassis_number' => ['required', 'max:30'],
                'registration_number' => ['required', 'max:30'],
                'description' => ['nullable', 'max:250'],
            ])
        );

        return Redirect::route('vehicles')->with('success', 'Vehicle added.');
    }

   
    public function edit(Vehicle $vehicle)
    {
        return Inertia::render('Vehicles/Edit', [
            'vehicles' => [
                'id' => $vehicle->id,
                'driver_name' => $vehicle->driver_name,
                'driver_phone' => $vehicle->driver_phone,
                'chassis_number' => $vehicle->chassis_number,
                'registration_number' => $vehicle->registration_number,
                'description' => $vehicle->description,
                'deleted_at' => $vehicle->deleted_at,
            ],
        ]);
    }


    public function update(Vehicle $vehicle)
    {


        $vehicle->update(
            Request::validate([
                'driver_name' => ['required', 'max:50'],
                'driver_phone' => ['required', 'max:25'],
                'chassis_number' => ['required', 'max:30'],
                'registration_number' => ['required', 'max:30'],
                'description' => ['nullable', 'max:250'],
            ])
        );

        return Redirect::back()->with('success', 'Vehicle updated.');
    }


    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return Redirect::back()->with('success', 'Vehicle deleted.');
    }


    public function restore(Vehicle $vehicle)
    {
        $vehicle->restore();

        return Redirect::back()->with('success', 'Vehicle restored.');
    }
}
