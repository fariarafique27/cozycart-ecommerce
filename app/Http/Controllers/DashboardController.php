<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function customerIndex()
    {
        return view('shop.index'); // Customer landing view
    }

    public function adminIndex()
    {
        return view('admin.dashboard'); // Admin landing view
    }
}