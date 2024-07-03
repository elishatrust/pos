<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'products';

    static public function getProduct()
    {
        // return DB::table('products')->where('archive', '=', 0)->orderBy('id','desc')->get();

        return DB::table('products')
            ->join('warehouses', 'products.warehouse_id', '=', 'warehouses.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('users', 'products.supplier_id', '=', 'users.id')
            ->where('products.archive', '=', 0)
            ->select('products.*',
                'warehouses.name as warehouse_name',
                'categories.name as category_name',
                'users.name as user_name'
                )
            ->orderBy('products.id', 'desc')
            ->get();
    }

    static public function findProduct($id)
    {
        return DB::table('products')->where('id', '=', $id)->first();
    }


    static public function updateProduct($id)
    {
        return DB::table('products')->where('id', '=', $id)->update(['archive' => 1]);
    }

    static public function getCountable()
    {
        return DB::table('products')->where('archive','=',0)->count();
    }

}
