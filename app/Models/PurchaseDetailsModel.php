<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetailsModel extends Model
{
    protected $connection = 'mysql';
    protected $table = 'purchase_details';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $fillable = [
        'id',
        'purchase_id',
        'product_id',
        'purchasePrice',
        'amount',
        'sub_total',
        'status',
        'archive',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
