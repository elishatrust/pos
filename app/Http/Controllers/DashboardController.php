<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\WarehouseModel;
use App\Models\CategoryModel;
use App\Models\SaleModel;
use App\Models\User;
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
            $user = User::getCountable();
            $inactiveUser = User::getCountableInactive();
            $product = ProductModel::getCountable();
            $category = CategoryModel::getCountable();
            $warehouse = WarehouseModel::getCountable();
            // $sales = SaleModel::getCountable();    
            return view('pos.dashboard.admin_dashboard', compact('data', 'user','inactiveUser','warehouse', 'product', 'category'));
        } 
        elseif ($userRole == '2') 
        {
            $warehouse = $product = $category = null;
            return view('pos.dashboard.user_dashboard', compact('data', 'warehouse', 'product', 'category'));
        } 
        else 
        {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }
    }

}
