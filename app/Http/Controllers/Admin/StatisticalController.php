<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticalController extends Controller
{
    public function dashboard(){
        $totalSoldQuantity = Product::sum('sold_quantity');
        $totalRevenue = Order::sum('total');
        return view('admin.dashboard.index',[
            'totalSoldQuantity' => $totalSoldQuantity,
            'totalRevenue' => $totalRevenue,
        ]);
    }
}
