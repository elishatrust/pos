<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WarehouseModel extends Model
{
    use HasFactory;

    protected $table = 'warehouses';

    static public function getWarehouse()
    {
        return DB::table('warehouses')
            ->join('users', 'warehouses.manager','=','users.id')
            ->where('warehouses.archive', '=', 0)
            ->select('warehouses.*', 'users.name as user_name')
            ->orderBy('warehouses.id','desc')
            ->get();
    }

    static public function findWarehouse($id)
    {
        return DB::table('warehouses')->where('id', '=', $id)->first();
    }


    static public function updateWarehouse($id)
    {
        return DB::table('warehouses')->where('id', '=', $id)->update(['archive' => 1]);
    }
}
