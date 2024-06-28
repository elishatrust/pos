<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list()
    {
        $data = [
                'title' => 'POS System v1.0',
                'header' => 'User',
            ];

        $warehouses = WarehouseModel::getWarehouse();
        return view('pos.user.list', compact('data','warehouses'));
    }

    public function listView()
    {
        $data = User::getUser();
        return view('pos.user.list_view', compact('data'));
    }

    public function saveUser(Request $request)
    {
        try {
            DB::beginTransaction();

            $hidden_id = $request->input('hidden_id');
            $full_name = $request->input('full_name');
            $username = $request->input('username');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $location = $request->input('location');
            $password = $request->input('password');
            $warehouse_id = $request->input('warehouse_id');
            $role = $request->input('role');
            $u_status = $request->input('u_status');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'name' => $full_name,
                    'username' => $username,
                    'phone' => $phone,
                    'email' => $email,
                    'location' => $location,
                    'warehouse_id' => $warehouse_id,
                    'role' => $role,
                    'password' => Hash::make($password),
                    'status' => $u_status,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                ## Save data
                DB::table('users')->insertGetId($saveData);
                $message='User saved successfully';

            else:

                $saveData = [
                    'name' => $full_name,
                    'username' => $username,
                    'phone' => $phone,
                    'email' => $email,
                    'location' => $location,
                    'warehouse_id' => $warehouse_id,
                    'role' => $role,
                    'status' => $u_status,
                    'updated_by' => $user_id,
                ];

                $condition=[
                    'id'=>Crypt::decrypt($hidden_id),
                    'archive'=>0
                ];

                ## Save data
                DB::table('users')->where($condition)->update($saveData);
                $message='User updated successfully';

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function editUser($id)
    {
        $data = User::findUser($id);
        return response()->json(['data'=>$data, 'id'=>Crypt::encrypt($id)]);
    }

    public function deleteUser($id)
    {
        try {
            $data = User::updateUser($id);
            if($data)
            {
                $message='User deleted successfully';
                return response()->json(['status' => 200, 'message' => $message]);
            }else{
                $message='Something went wrong. Try again!';
                return response()->json(['status' => 450, 'message' => $message]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }

    }

    public function userRole()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $role_id = $user->role;
        $role = '';

        switch ($role_id) {
            case 1:
                $role = 'Administrator';
                break;
            case 2:
                $role = 'Cashier';
                break;
            default:
            $role = 'Unknown Role';
        }
        return response()->json(['role' => $role]);
    }
}
