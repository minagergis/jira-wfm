<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    //

    public function getDashboard()
    {
        return view('dashboard');
    }
}
