<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\PurchaseDetailsModel;
use Illuminate\Http\Request;
use App\Models\PurchaseModel;
use App\Models\WarehouseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PurchaseController extends Controller
{
    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = [
            'title' => 'POS-SYSTEM',
            'header' => 'Purchase',
        ];
        $suppliers = WarehouseModel::where('status','=',0)->where('archive','=',0)->get();

        return view('pos.purchase.list', compact('data','suppliers'));
    }
    public function listView()
    {
        $data = DB::table('purchases as p')
            ->join('warehouses as w', 'p.supplier_id', '=', 'w.id')
            ->select('p.*', 'w.name as supplier_name')
            ->where('p.archive','=',0)
            ->orderBy('p.id','desc')
            ->get();

        return view('pos.purchase.list_view', compact('data'));
    }
    public function savePurchase(Request $request)
    {
        try {
            
            $request->validate([
                'supplier_id' => 'required|exists:warehouses,id',
                'total_item' => 'required|numeric|min:0',
                'total_price' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0|max:1000',
                'showStatus' => 'required|in:0,1',
                'hidden_id' => 'nullable',
            ]);           

            DB::beginTransaction();

            $hidden_id = $request->input('hidden_id');
            $supplier_id = $request->input('supplier_id');
            $total_item = $request->input('total_item');
            $total_price = $request->input('total_price');
            $discount = $request->input('discount');
            $showStatus = $request->input('showStatus');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'supplier_id' => $supplier_id,
                    'total_item' => $total_item,
                    'total_price' => $total_price,
                    'discount' => $discount,
                    'status' => $showStatus,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                ## Save data
                DB::table('purchases')->insertGetId($saveData);
                $message='Purchase saved successfully';

            else:

                $saveData = [
                    'supplier_id' => $supplier_id,
                    'total_item' => $total_item,
                    'total_price' => $total_price,
                    'discount' => $discount,
                    'status' => $showStatus,
                    'updated_by' => $user_id,
                ];

                $condition=[
                    'id'=>Crypt::decrypt($hidden_id),
                    'archive'=>0
                ];

                ## Save data
                DB::table('purchases')->where($condition)->update($saveData);
                $message='Purchase updated successfully';

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function editPurchase($id)
    {
        $data = PurchaseModel::findOrFail($id);
        return response()->json(['data'=>$data, 'id'=>Crypt::encrypt($id)]);
    }

    public function deletePurchase($id)
    {
        try {
            $data = PurchaseModel::where('id','=',$id)->update(['archive' => 1]);
            if($data)
            {
                $message='Purchase deleted successfully';
                return response()->json(['status' => 200, 'message' => $message]);
            }else{
                $message='Something went wrong. Try again!';
                return response()->json(['status' => 450, 'message' => $message]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }

    }

    public function purchaseDetails($purchase_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = [
            'title' => 'POS-SYSTEM',
            'header' => 'Purchase Details',
        ];

        // $purchase_id = decrypt($id);
        $products = ProductModel::query()->where('archive',0)->where('status',0)->get();  
        
        $purchase_details = PurchaseDetailsModel::get();  

            // dd($purchase_details);

        return view('pos.purchase.purchase_details', compact('data','products','purchase_id','purchase_details'));

    }

    public function purchaseDetailsView()
    {
        // $purchase = PurchaseModel::query()
        //     ->join('warehouses', 'purchases.supplier_id', '=', 'warehouses.id')
        //     ->where('purchases.id', $id)
        //     ->where('purchases.status', 0)
        //     ->where('purchases.archive', 0)
        //     ->first();

        // if($purchase){
        //     return response()->json(['status'=>200,'purchase'=>$purchase]);
        // }else{
        //     $message = 'No details available';
        //     return response()->json(['status'=>450,'purchase'=>$message]);
        // }
        
        // $suppliers = WarehouseModel::query()->where('archive',0)->where('status',0)->get(); 

        return view('pos.purchase.purchase_details_view');
    }

    public function savePurchaseDetails(Request $request)
    {   
        try {
            
            $request->validate([
                'purchase_id' => 'required|exists:purchases,id',
                'product_id' => 'required|exists:products,id',
                'purchase_price' => 'required|numeric|min:0',
                'amount' => 'required|numeric|min:0',
                'sub_total' => 'required|numeric|min:0',
                'showStatus' => 'required|in:0,1',
                'hidden_id' => 'nullable',
            ]);           

            DB::beginTransaction();

            $hidden_id = $request->input('hidden_id');
            $purchase_id = $request->input('purchase_id');
            $product_id = $request->input('product_id');
            $purchase_price = $request->input('purchase_price');
            $amount = $request->input('amount');
            $sub_total = $request->input('sub_total');
            $showStatus = $request->input('showStatus');
            $user_id = Auth::user()->id;

            if(empty($hidden_id)):
                $saveData = [
                    'purchase_id' => $purchase_id,
                    'product_id' => $product_id,
                    'purchasePrice' => $purchase_price,
                    'amount' => $amount,
                    'sub_total' => $sub_total,
                    'status' => $showStatus,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                ## Save data
                DB::table('purchase_details')->insertGetId($saveData);
                $message='Purchase details saved successfully';

            else:

                $saveData = [
                    'product_id' => $product_id,
                    'purchasePrice' => $purchase_price,
                    'amount' => $amount,
                    'sub_total' => $sub_total,
                    'status' => $showStatus,
                    'updated_by' => $user_id,
                ];

                $condition=[
                    'id'=>Crypt::decrypt($hidden_id),
                    'archive'=>0
                ];

                ## Save data
                DB::table('purchase_details')->where($condition)->update($saveData);
                $message='Purchase details updated successfully';

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
