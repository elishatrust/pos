<?php

namespace App\Http\Controllers;

use App\Models\SaleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SalesController extends Controller
{
    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $data = [
            'title' => 'POS-SYSTEM',
            'header' => 'Sales',
        ];

        $customers = User::where('archive','=',0)->where('role','!=',1)->get();
        
        return view('pos.sales.list', compact('data','customers'));
    }

    public function listView()
    {
        $data = DB::table('sales as s')
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->select('s.*', 'u.name as customer_name')
            ->where('s.archive','=',0)
            ->orderBy('s.id','desc')
            ->get();

        return view('pos.sales.list_view', compact('data'));
    }

    public function saveSales(Request $request)
    {
        try {
            
            $request->validate([
                'customer_id' => 'required|exists:users,id',
                'total_item' => 'required|numeric|min:0',
                'total_price' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0',
                'accept' => 'required|in:yes,no',
                'showStatus' => 'required|in:0,1',
                'hidden_id' => 'nullable',
            ]);           

            DB::beginTransaction();

            $hidden_id = $request->input('hidden_id');
            $customer_id = $request->input('customer_id');
            $total_item = $request->input('total_item');
            $total_price = $request->input('total_price');
            $discount = $request->input('discount');
            $accept = $request->input('accept');
            $showStatus = $request->input('showStatus');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'user_id' => $customer_id,
                    'total_item' => $total_item,
                    'total_price' => $total_price,
                    'discount' => $discount,
                    'accept' => $accept,
                    'status' => $showStatus,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                ## Save data
                DB::table('sales')->insertGetId($saveData);
                $message='Sale saved successfully';

            else:

                $saveData = [
                    'user_id' => $customer_id,
                    'total_item' => $total_item,
                    'total_price' => $total_price,
                    'discount' => $discount,
                    'accept' => $accept,
                    'status' => $showStatus,
                    'updated_by' => $user_id,
                ];

                $condition=[
                    'id'=>Crypt::decrypt($hidden_id),
                    'archive'=>0
                ];

                ## Save data
                DB::table('sales')->where($condition)->update($saveData);
                $message='Sale updated successfully';

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
    public function editSales($id)
    {
        $data = SaleModel::findOrFail($id);
        return response()->json(['data'=>$data, 'id'=>Crypt::encrypt($id)]);
    }

    public function deletePurchase($id)
    {
        try {
            $data = SaleModel::where('id','=',$id)->update(['archive' => 1]);
            if($data)
            {
                $message='Sale deleted successfully';
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
