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
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = [
            'title' => 'POS-SYSTEM',
            'header' => 'Product',
        ];

        $categories = CategoryModel::getCategory();
        return view('pos.product.list', compact('data','categories'));
    }

    public function listView()
    {
        $data = ProductModel::getProduct();
        return view('pos.product.list_view', compact('data'));
    }

    public function saveProduct(Request $request)
    {
        try {
            
            $request->validate([
                'batch' => 'required|string|max:255',
                'product' => 'required|string|max:255',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'discount' => 'nullable|numeric|min:0|max:1000',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'product_status' => 'required|in:0,1',
                'hidden_id' => 'nullable',
            ]);           

            DB::beginTransaction();

            $number = mt_rand(1000000000, 9999999999);
            $generateCode = new BarcodeGeneratorHTML();
            $barcode = $generateCode->getBarcode($number, $generateCode::TYPE_CODE_128);

            $hidden_id = $request->input('hidden_id');
            $batch = $request->input('batch');
            $product = $request->input('product');
            $purchase_price = $request->input('purchase_price');
            $selling_price = $request->input('selling_price');
            $discount = $request->input('discount');
            $stock = $request->input('stock');
            $prodStatus = $request->input('product_Status');
            $category_id = $request->input('category_id');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'batch' => $batch,
                    'bar_code' => $barcode,
                    'barcode' => $number,
                    'product' => $product,
                    'purchase_price' => $purchase_price,
                    'selling_price' => $selling_price,
                    'discount' => $discount,
                    'stock' => $stock,
                    'category_id' => $category_id,
                    'status' => $prodStatus,
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
                    // 'bar_code' => $barcode,
                    // 'barcode' => $number,
                    'batch' => $batch,
                    'product' => $product,
                    'purchase_price' => $purchase_price,
                    'selling_price' => $selling_price,
                    'discount' => $discount,
                    'stock' => $stock,
                    'category_id' => $category_id,
                    'status' => $prodStatus,
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
