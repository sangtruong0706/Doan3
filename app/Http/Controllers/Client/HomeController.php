<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    protected $product;
    public function __construct(Product $product){
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->latest('id')->paginate(8);
        return view('client.home.index', compact('products'));
    }
}
