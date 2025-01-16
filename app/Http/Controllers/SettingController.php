<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $data = [
                'title' => 'POS-SYSTEM',
                'header' => 'Settings'
            ];

        $users = User::getUser();
        return view('pos.settings.setting', compact('data','users'));
    }

    public function getSettings()
    {
        $data = SettingModel::getSettings();
        return response()->json(array('data' => $data));
    }

    public function updateSettings(Request $request, $id)
    {
        $business = $request->input('business');
        $tagline = $request->input('tagline');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $address = $request->input('address');
        $website = $request->input('website');

        $data = array(
            'business' => $business,
            'tagline' => $tagline,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'website' => $website,
        );

        DB::table('settings')->where('id', $id)->update($data);

        return response()->json(['status' => 200, 'message' => 'Settings updated successfully']);
    

    }
}
