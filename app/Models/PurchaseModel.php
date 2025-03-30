<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseModel extends Model
{
    protected $table = 'purchases';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'supplier_id',
        'total_item',
        'total_price',
        'discount',
        'status',
        'archive',
        'created_by',
        'updated_by'
    ];

}
