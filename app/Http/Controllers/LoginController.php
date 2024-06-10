<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class LoginController extends Controller
{
    public function index()
    {
        $data = [
                'title' => 'POS System v1.0',
                'header' => 'Login'
            ];
        return view('auth.login', compact('data'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => 200,
                'message' => 'Login Successfully',
                'redirect_url' => route('dashboard')
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Invalid Email or Password'
        ]);
    }

    public function resetPassword()
    {
        $data = [
                'title' => 'POS System v1.0',
                'header' => 'Reset Password'
            ];
        return view('auth.reset', compact('data'));
    }

    public function profile()
    {
        $data = [
                'title' => 'POS System v1.0',
                'header' => 'My Profile'
            ];
        return view('pos.profile', compact('data'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
