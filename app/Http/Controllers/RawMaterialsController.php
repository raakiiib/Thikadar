<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class RawMaterialsController extends Controller
{


	public function index()
	{
		return Inertia::render('Materials/Index', [
            'filters' => Request::all('search', 'trashed'),
            'materials' => Auth::user()->account->materials()
                ->orderBy('name')
				->filter(Request::only('search', 'trashed'))
				->paginate()
				->only('id', 'name', 'type', 'unit', 'description', 'deleted_at'),
        ]);

	}


    public function create()
    {
        return Inertia::render('Materials/Create');
    }


	
    public function store()
    {
        Auth::user()->account->materials()->create(
            Request::validate([
            	'name' => ['required', 'max:100'],
                'type' => ['nullable', 'max:100'],
                'unit' => ['nullable', 'max:20'],
                'description' => ['nullable', 'max:450'],
            ])
        );

        return Redirect::route('materials')->with('success', 'Material added.');
    }

    public function edit(RawMaterial $material)
    {
        return Inertia::render('Materials/Edit', [
            'material' => [
                'id' => $material->id,
                'name' => $material->name,
                'size' => $material->size,
                'type' => $material->type,
                'unit' => $material->unit,
                'description' => $material->description,
                'deleted_at' => $material->deleted_at,
            ],
        ]);
    }

    public function update(RawMaterial $material)
    {
        $material->update(
            Request::validate([
            	'name' => ['required', 'max:100'],
                'name' => ['required', 'max:100'],
                'unit' => ['required', 'max:20'],
                'description' => ['nullable', 'max:450'],
            ])
        );

        return Redirect::back()->with('success', 'Material updated.');
    }

    public function destroy(RawMaterial $material)
    {
        $material->delete();

        return Redirect::back()->with('success', 'Material deleted.');
    }

    public function restore(RawMaterial $material)
    {
        $material->restore();

        return Redirect::back()->with('success', 'Material restored.');
    }
}
