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
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = [
                'title' => 'POS-SYSTEM',
                'header' => 'User',
            ];

        return view('pos.user.list', compact('data'));
    }

    public function listView(Request $request)
    {
        $data = User::getUser();

        // Search Start
        $search = User::orderBy('id','desc');
        if($request->id) 
        $search = $search->where('id','=',$request->id);

        if($request->name) 
        $search = $search->where('name','like','%'.$request->name.'%');

        if($request->username) 
        $search = $search->where('username','like','%'.$request->username.'%');
    
        if($request->email) 
        $search = $search->where('email','like','%'.$request->email.'%');
        // Search End

        return view('pos.user.list_view', compact('data'));
    }

    public function saveUser(Request $request)
    {
        try {

            $request->validate([
                'full_name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'user_email' => 'required|email',
                'location' => 'required|string|max:255',
                'password' => 'nullable|string|min:3',
                'phone' => 'required|digits:10',
                'user_role' => 'required|string',
                'user_status' => 'required|in:0,1',
                'hidden_id' => 'nullable',
            ]);  

            DB::beginTransaction();

            $hidden_id = $request->input('hidden_id');
            $full_name = $request->input('full_name');
            $username = $request->input('username');
            $phone = $request->input('phone');
            $email = $request->input('user_email');
            $location = $request->input('location');
            $password = $request->input('password');
            $role = $request->input('user_role');
            $user_status = $request->input('user_status');
            $user_id = Auth::user()->id;
            $user_code = rand(00000,99999);    

            if(empty($hidden_id)):
                $saveData = [
                    'name' => $full_name,
                    'username' => $username,
                    'phone' => $phone,
                    'email' => $email,
                    'location' => $location,
                    'role' => $role,
                    'user_code' => $user_code,
                    'password' => Hash::make($password),
                    'status' => $user_status,
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
                    'role' => $role,
                    'status' => $user_status,
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

    public function userData()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $role_id = $user->role;

        switch ($role_id) {
            case 1:
                $data = [
                    'role' => 'Administrator',
                    'name' => $user->name,
                    'email'=> $user->email,
                ];
                break;
            case 2:
                $data = [
                    'role' => 'Cashier',
                    'name' => $user->name,
                    'email'=> $user->email,
                ];
                break;
            default:
                $data = [
                    'role'=> 'Unknown Role',
                    'name'=> $user->name,
                    'email'=> $user->email,
                ];
        }
        return response()->json(['data' => $data]);
    }

    public function searchCustomer($query)
    {
        $data = User::searchUser($query);

        $view = '';
        if ($data) {            
            foreach ($data as $val) {
                $view .= '<a><li style="background-color: #dee2e6; color:#000; border: 1px solid #dee2e6; padding: 5px; list-style: none; cursor: pointer; z-index:1;width:100%;" onclick="addText(\'' . $val->id . '\', \'' . $val->name . '\', \'' . $val->phone . '\')">'
                .$val->name." ( ".$val->phone . ' ) </li></a>';
            }

        } else {
            $view .= '<a><li style="background-color: #dee2e6;color:#000; border: 1px solid #dee2e6; padding: 5px; list-style: none; cursor: pointer; z-index:1;width:100%;" > No Customer Found. </li></a>';
        }

        echo $view;
    }
}
