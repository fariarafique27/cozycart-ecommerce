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
        $data = [
            'totalProducts'    => Product::getCount(),
            'totalCategories'  => Category::getCount(),
            'totalUsers'       => User::countCustomers(),
        ];

        return view('admin.dashboard', $data);
    }
}