<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class CategoryController extends Controller
{
    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = [
            'title' => 'POS-SYSTEM',
            'header' => 'Category',
            'sub_header' => 'Category List'
        ];
        return view('pos.category.list', compact('data'));
    }

    public function listView()
    {
        $data = CategoryModel::getCategory();
        return view('pos.category.list_view', compact('data'));
    }

    public function saveCategory(Request $request)
    {
        try {

            $request->validate([
                'category' => 'required|string|max:255',
                'category_status' => 'required|in:0,1',
                'hidden_id' => 'nullable'
            ]);
    
            DB::beginTransaction();

            $hidden_id = $request->input('hidden_id');
            $category = $request->input('category');
            $status = $request->input('category_status');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'name' => $category,
                    'status' => $status,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                ## Save data
                DB::table('categories')->insertGetId($saveData);
                $message='Category saved successfully';

            else:

                $saveData = [
                    'name' => $category,
                    'status' => $status,
                    'updated_by' => $user_id,
                ];

                $condition=[
                    'id'=>Crypt::decrypt($hidden_id),
                    'archive'=>0
                ];

                ## Save data
                DB::table('categories')->where($condition)->update($saveData);
                $message='Category updated successfully';

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);    
        }
    }

    public function editCategory($id)
    {
        $data = CategoryModel::findCategory($id);
        return response()->json(['data'=>$data, 'id'=>Crypt::encrypt($id)]);
    }

    public function deleteCategory($id)
    {
        try {
            $data = CategoryModel::updateCategory($id);
            if($data)
            {
                $message='Category deleted successfully';
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
