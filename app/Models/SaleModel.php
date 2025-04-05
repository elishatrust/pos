<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaleModel extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'id';

    static public function getCountable()
    {
        return DB::table('sales')->where('archive','=',0)->count();
    }
}
