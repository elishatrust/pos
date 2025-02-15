<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\WarehouseModel;
use App\Models\CategoryModel;
use App\Models\SaleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $data = [
            'title' => 'POS-SYSTEM',
            'header' => 'Dashboard',
        ];

        $userRole = Auth::user()->role;

        if ($userRole == '1') 
        {
            $warehouse = WarehouseModel::getCountable();
            $product = ProductModel::getCountable();
            $category = CategoryModel::getCountable();
            // $sales = SaleModel::getCountable();    
            return view('pos.admin_dashboard', compact('data', 'warehouse', 'product', 'category'));
        } 
        elseif ($userRole == '2') 
        {
            $warehouse = $product = $category = null;
            return view('pos.user_dashboard', compact('data', 'warehouse', 'product', 'category'));
        } 
        else 
        {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }
    }

}
