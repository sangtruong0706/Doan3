<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function index(Request $request, $categoryId)
    {
        $products = $this->product->getBy($request->all(), $categoryId);
        return view('client.products.index', compact('products'));
    }
    // public function filterByPrice(Request $request, $categoryId)
    // {
    //     $minPrice = $request->input('min_price');
    //     $maxPrice = $request->input('max_price');

    //     $filteredProducts = $this->product->getByPriceRange($categoryId, $minPrice, $maxPrice);

    //     return response()->json(['products' => $filteredProducts, 'categoryId' => $categoryId]);
    // }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $productDetail = $this->product->with('details')->findOrFail($id);
        return view('client.products.detail', compact('productDetail'));
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
