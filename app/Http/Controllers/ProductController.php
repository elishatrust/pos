<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\User;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductController extends Controller
{
    public function list()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        
        $data = [
                'title' => 'POS System v1.0',
                'header' => 'Stock Inventory',
            ];

        $warehouses = WarehouseModel::getWarehouse();
        $categories = CategoryModel::getCategory();
        $suppliers = User::getUser();
        return view('pos.product.list', compact('data','warehouses','categories','suppliers'));
    }

    public function listView()
    {
        $data = ProductModel::getProduct();
        return view('pos.product.list_view', compact('data'));
    }

    public function saveProduct(Request $request)
    {
        try {
            DB::beginTransaction();

            $number = mt_rand(1000000000, 9999999999);
            $generateCode = new BarcodeGeneratorHTML();
            $barcode = $generateCode->getBarcode($number, $generateCode::TYPE_CODE_128);

            $hidden_id = $request->input('hidden_id');
            $batch = $request->input('batch');
            $name = $request->input('product_name');
            $description = $request->input('description');
            $cost = $request->input('cost');
            $selling = $request->input('selling');
            $qty = $request->input('qty');
            $mft_date = $request->input('mft_date');
            $exp_date = $request->input('exp_date');
            $supplier_id = $request->input('supplier_id');
            $warehouse_id = $request->input('warehouse_id');
            $category_id = $request->input('category_id');
            $u_status = $request->input('u_status');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'batch' => $batch,
                    'bar_code' => $barcode,
                    'barcode' => $number,
                    'name' => $name,
                    'description' => $description,
                    'cost' => $cost,
                    'selling' => $selling,
                    'qty' => $qty,
                    'mft_date' => $mft_date,
                    'exp_date' => $exp_date,
                    'supplier_id' => $supplier_id,
                    'warehouse_id' => $warehouse_id,
                    'category_id' => $category_id,
                    'status' => $u_status,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                ## Save data
                DB::table('products')->insertGetId($saveData);
                $message='Product saved successfully';

            else:

                $saveData = [
                    'batch' => $batch,
                    'name' => $name,
                    // 'bar_code' => $barcode,
                    // 'barcode' => $number,
                    'description' => $description,
                    'cost' => $cost,
                    'selling' => $selling,
                    'qty' => $qty,
                    'mft_date' => $mft_date,
                    'exp_date' => $exp_date,
                    'supplier_id' => $supplier_id,
                    'warehouse_id' => $warehouse_id,
                    'category_id' => $category_id,
                    'status' => $u_status,
                    'updated_by' => $user_id,
                ];

                $condition=[
                    'id'=>Crypt::decrypt($hidden_id),
                    'archive'=>0
                ];

                ## Save data
                DB::table('products')->where($condition)->update($saveData);
                $message='Product updated successfully';

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function editProduct($id)
    {
        $data = ProductModel::findProduct($id);
        return response()->json(['data'=>$data, 'id'=>Crypt::encrypt($id)]);
    }

    public function deleteProduct($id)
    {
        try {
            $data = ProductModel::updateProduct($id);
            if($data)
            {
                $message='Product deleted successfully';
                return response()->json(['status' => 200, 'message' => $message]);
            }else{
                $message='Something went wrong. Try again!';
                return response()->json(['status' => 450, 'message' => $message]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }

    }


    public function searchProduct($query)
    {
        $data = ProductModel::searchProduct($query);

        $view = '';
        if ($data) {            
            foreach ($data as $val) {
                $view .= '<a><li style="background-color: #dee2e6; color:#000; border: 1px solid #dee2e6; padding: 5px; list-style: none; cursor: pointer; z-index:1000;width:100%;" onclick="addProduct(\'' . $val->id . '\', \'' . $val->name . '\', \'' . $val->selling . '\')">'
                .$val->name.'</li></a>';
            }

        } else {
            $view .= '<a><li style="background-color: #dee2e6;color:#000; border: 1px solid #dee2e6; padding: 5px; list-style: none; cursor: pointer; z-index:1000;width:100%;" > No Product Found. </li></a>';
        }

        echo $view;
    }


}
