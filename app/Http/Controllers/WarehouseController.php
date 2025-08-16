<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class WarehouseController extends Controller
{
    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = [
                'title' => 'POS-SYSTEM',
                'header' => 'Supplier',
            ];

        $users = User::getUser();
        return view('pos.supplier.list', compact('data','users'));
    }

    public function listView()
    {
        $data = WarehouseModel::getWarehouse();
        return view('pos.supplier.list_view', compact('data'));
    }

    public function saveSupplier(Request $request)
    {
        try {
            DB::beginTransaction();

            $hidden_id = $request->input('hidden_id');
            $name = $request->input('name');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $location = $request->input('location');
            $user_id = $request->input('user_id');
            $show_status = $request->input('show_status');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'location' => $location,
                    'manager' => $user_id,
                    'show_status' => $show_status,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                ## Save data
                DB::table('warehouses')->insertGetId($saveData);
                $message='Supplier saved successfully';

            else:

                $saveData = [
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'location' => $location,
                    'manager' => $user_id,
                    'show_status' => $show_status,
                    'updated_by' => $user_id,
                ];

                $condition=[
                    'id'=>Crypt::decrypt($hidden_id),
                    'archive'=>0
                ];

                ## Save data
                DB::table('warehouses')->where($condition)->update($saveData);
                $message='Supplier updated successfully';

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function editSupplier($id)
    {
        $data = WarehouseModel::findWarehouse($id);
        return response()->json(['data'=>$data, 'id'=>Crypt::encrypt($id)]);
    }

    public function deleteSupplier($id)
    {
        try {
            $data = WarehouseModel::updateWarehouse($id);
            if($data)
            {
                $message='Supplier deleted successfully';
                return response()->json(['status' => 200, 'message' => $message]);
            }else{
                $message='Something went wrong. Try again!';
                return response()->json(['status' => 450, 'message' => $message]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }

    }
}
