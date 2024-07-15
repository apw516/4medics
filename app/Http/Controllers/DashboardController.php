<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    Public function Index()
    {
        $menu = 'dashboard';
        return view('Dashboard.Index',compact([
            'menu'
        ]));
    }
}
