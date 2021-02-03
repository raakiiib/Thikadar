<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class SettingsController extends Controller
{


    public function index()
    {
        return Inertia::render('Settings/Index');
    }

}
