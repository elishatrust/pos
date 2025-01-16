<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('pos.sales.list', compact('data'));
    }

    public function listView()
    {
        return view('pos.sales.list_view');
    }
}
