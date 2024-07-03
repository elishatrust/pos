<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function list()
    {
        $data = [
            'title' => 'POS System v1.0',
            'header' => 'Sales',
        ];

        return view('pos.sales.list', compact('data'));
    }

    public function listView()
    {
        return view('pos.sales.list_view');
    }
}
