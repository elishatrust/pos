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
        return DB::table('products')
            ->join('users', 'products.created_by','=','users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.archive', '=', 0)
            ->select('products.*',
                'users.name as user_name',
                'categories.name as category_name',
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


    static public function searchProduct($query)
    {
        return DB::table('products')->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->where('archive', 0)
            ->get();
    }


}
