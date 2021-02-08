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
				->only('id', 'name', 'dimension', 'size', 'unit', 'description', 'created_at', 'deleted_at'),
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
                'dimension' => ['nullable', 'max:100'],
                'size' => ['nullable', 'max:50'],
                'unit' => ['nullable', 'max:20'],
                'description' => ['nullable', 'max:450'],
            ])
        );

        return Redirect::route('services')->with('success', 'service added.');
    }

    public function edit(Service $service)
    {
        return Inertia::render('Services/Edit', [
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
                'dimension' => $service->dimension,
                'size' => $service->size,
                'unit' => $service->unit,
                'description' => $service->description,
                'deleted_at' => $service->deleted_at,
            ],
        ]);
    }

    public function update(Service $service)
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

    public function destroy(Service $service)
    {
        $service->delete();

        return Redirect::back()->with('success', 'service deleted.');
    }

    public function restore(Service $service)
    {
        $service->restore();

        return Redirect::back()->with('success', 'service restored.');
    }
}
