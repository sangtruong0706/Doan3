<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticalController extends Controller
{
    protected $product;
    public function __construct(Product $product){
        $this->product = $product;
    }
    public function dashboard()
    {
        $revenue=0;
        $all_products = $this->product->all();
        $totalSoldQuantity = $this->product->sum('sold_quantity');
        foreach ($all_products as $item){
            $quantitySold = $item->sold_quantity; // Số lượng bán
            $productPrice = $item->price;      // Giá sản phẩm
            $sub_revenue = $quantitySold * $productPrice; // Doanh thu
            $revenue += $sub_revenue;
        }

        return view('admin.dashboard.index', [
            'totalSoldQuantity' => $totalSoldQuantity,
            'totalRevenue' => $revenue,
        ]);
    }
}
