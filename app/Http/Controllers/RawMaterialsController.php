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
                ->orderBy('product_name')
				->filter(Request::only('search', 'trashed'))
				->paginate()
				->only('id', 'product_name', 'unit', 'description', 'deleted_at'),
        ]);


        // return Inertia::render('Organizations/Index', [
        //     'filters' => Request::all('search', 'trashed'),
        //     'organizations' => Auth::user()->account->organizations()
        //         ->orderBy('name')
        //         ->filter(Request::only('search', 'trashed'))
        //         ->paginate()
        //         ->only('id', 'name', 'phone', 'city', 'deleted_at'),
        // ]);
	}


	public function create()
    {
        return Inertia::render('Materials/Create', [
            'materials' => Auth::user()->account
                ->materials()
                ->orderBy('product_name')
                ->get()
                ->map
                ->only('id', 'product_name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->materials()->create(
            Request::validate([
            	'product_name' => ['required', 'max:50'],
                'unit' => ['required', 'max:50'],
                'description' => ['nullable', 'max:250'],
            ])
        );

        return Redirect::route('materials')->with('success', 'Material added.');
    }

    public function edit(RawMaterial $material)
    {
        // dd($material);
        return Inertia::render('Materials/Edit', [
            'material' => [
                'id' => $material->id,
                'product_name' => $material->product_name,
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
            	'product_name' => ['required', 'max:50'],
                'unit' => ['required', 'max:50'],
                'description' => ['nullable', 'max:250'],
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
