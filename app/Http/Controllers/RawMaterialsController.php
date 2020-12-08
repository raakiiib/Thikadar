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
            'materials' => RawMaterial::query()
                ->orderBy('id')
				->filter(Request::only('search'))
				->paginate()
				->only('id', 'product_name', 'unit', 'description'),
        ]);
	}

}
