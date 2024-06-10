<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    static public function getUser()
    {
        // return DB::table('users')->where('archive', '=', 0)->orderBy('id','desc')->get();

        return DB::table('users')
            ->join('warehouses', 'users.warehouse_id', '=', 'warehouses.id')
            ->where('users.archive', '=', 0)
            ->select('users.*', 'warehouses.name as warehouse_name')
            ->orderBy('users.id', 'desc')
            ->get();
    }

    static public function findUser($id)
    {
        return DB::table('users')->where('id', '=', $id)->first();
    }


    static public function updateUser($id)
    {
        return DB::table('users')->where('id', '=', $id)->update(['archive' => 1]);
    }

}
