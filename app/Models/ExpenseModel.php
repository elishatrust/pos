<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseModel extends Model
{
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'description',
        'amount',
        'status',
        'archive',
        'created_by',
        'updated_by'
    ];
}
