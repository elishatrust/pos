<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';

    static public function getCategory()
    {
        return DB::table('categories')
            ->join('users', 'categories.created_by','=','users.id')
            ->where('categories.archive', '=', 0)
            ->select('categories.*', 'users.name as user_name')
            ->orderBy('categories.id','desc')
            ->get();
    }

    static public function findCategory($id)
    {
        return DB::table('categories')->where('id', '=', $id)->first();
    }


    static public function updateCategory($id)
    {
        return DB::table('categories')->where('id', '=', $id)->update(['archive' => 1]);
    }
}
