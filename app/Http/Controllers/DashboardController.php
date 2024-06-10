<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
                'title' => 'POS System v1.0',
                'header' => 'Dashboard'
            ];
        return view('pos.dashboard', compact('data'));
    }
}
