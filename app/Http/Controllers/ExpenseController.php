<?php

namespace App\Http\Controllers;

use App\Models\ExpenseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ExpenseController extends Controller
{
    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = [
            'title' => 'POS-SYSTEM',
            'header' => 'Expense',
        ];

        return view('pos.expense.list', compact('data'));
    }

    public function listView()
    {
        $data = ExpenseModel::where('archive','=',0)->orderBy('id','desc')->get();
        return view('pos.expense.list_view', compact('data'));
    }
    public function saveExpense(Request $request)
    {
        try {
            DB::beginTransaction();

            $hidden_id = $request->input('hidden_id');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $showStatus = $request->input('showStatus');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'description' => $description,
                    'amount' => $amount,
                    'status' => $showStatus,
                    'archive' => 0,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                ## Save data
                DB::table('expenses')->insertGetId($saveData);
                $message='Expense saved successfully';

            else:

                $saveData = [
                    'description' => $description,
                    'amount' => $amount,
                    'status' => $showStatus,
                    'updated_by' => $user_id,
                ];

                $condition=[
                    'id'=>Crypt::decrypt($hidden_id),
                    'archive'=>0
                ];

                ## Save data
                DB::table('expenses')->where($condition)->update($saveData);
                $message='Expense updated successfully';

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function editExpense($id)
    {
        $data = ExpenseModel::findOrFail($id);
        return response()->json(['data'=>$data, 'id'=>Crypt::encrypt($id)]);
    }

    public function deleteExpense($id)
    {
        try {
            $data = ExpenseModel::where('id', '=', $id)->update(['archive' => 1]);;
            if($data)
            {
                $message='Expense deleted successfully';
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
