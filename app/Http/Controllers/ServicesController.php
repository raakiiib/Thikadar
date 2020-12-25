<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class ServicesController extends Controller
{


	public function index()
	{
		return Inertia::render('Services/Index', [
            'filters' => Request::all('search', 'trashed'),
            'services' => Auth::user()->account->services()
                ->orderBy('name')
				->filter(Request::only('search', 'trashed'))
				->paginate()
				->only('id', 'name', 'size', 'type', 'unit', 'description', 'created_at', 'deleted_at'),
        ]);
	}


    public function create()
    {
        return Inertia::render('Services/Create');
    }


	
    public function store()
    {
        Auth::user()->account->services()->create(
            Request::validate([
            	'name' => ['required', 'max:100'],
                'type' => ['nullable', 'max:100'],
                'unit' => ['nullable', 'max:20'],
                'description' => ['nullable', 'max:450'],
            ])
        );

        return Redirect::route('services')->with('success', 'service added.');
    }

    public function edit(Services $service)
    {
        return Inertia::render('services/Edit', [
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
                'size' => $service->size,
                'type' => $service->type,
                'unit' => $service->unit,
                'description' => $service->description,
                'deleted_at' => $service->deleted_at,
            ],
        ]);
    }

    public function update(Services $service)
    {
        $service->update(
            Request::validate([
            	'name' => ['required', 'max:100'],
                'name' => ['required', 'max:100'],
                'unit' => ['required', 'max:20'],
                'description' => ['nullable', 'max:450'],
            ])
        );

        return Redirect::back()->with('success', 'service updated.');
    }

    public function destroy(Services $service)
    {
        $service->delete();

        return Redirect::back()->with('success', 'service deleted.');
    }

    public function restore(Services $service)
    {
        $service->restore();

        return Redirect::back()->with('success', 'service restored.');
    }
}
