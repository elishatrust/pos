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
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        
        $data = [
                'title' => 'POS System v1.0',
                'header' => 'Dashboard'
            ];

        $warehouse = WarehouseModel::getCountable(); 
        $product = ProductModel::getCountable();
        $category = CategoryModel::getCountable();
        // $sales = SaleModel::getCountable();

        return view('pos.dashboard', compact('data', 'warehouse', 'product','category'));
    }
}
