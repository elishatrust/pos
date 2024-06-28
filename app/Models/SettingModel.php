<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SettingModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'business', 
        'tagline', 
        'phone', 
        'email', 
        'address', 
        'website'
    ];

    // protected $table = 'settings';


    static public function getSettings()
    {
        return DB::table('settings')->first();
    }


}
