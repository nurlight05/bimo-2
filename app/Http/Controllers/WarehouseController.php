<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('warehouse.index');
    }

    public function create()
    {
        return view('warehouse.create');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouse.edit', [
            'income' => $warehouse
        ]);
    }
}
