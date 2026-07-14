<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function customerIndex()
    {
        return view('shop.index'); // Customer landing view
    }

    public function adminIndex()
    {
        $totalProducts =  Product::count();
        $totalCategories = Category::count();

        // Optional: If you want to show total customers/users as well
        $totalUsers = User::where('role', '!=', 'admin')->count();

        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalUsers')); 
    }
}