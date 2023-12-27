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
    // public function filterProducts(Request $request, $category)
    // {
    //     $minPrice = $request->input('min_price');
    //     $maxPrice = $request->input('max_price');

    //     // Nếu $minPrice và $maxPrice là chuỗi rỗng, gán giá trị null
    //     $minPrice = empty($minPrice) ? null : $minPrice;
    //     $maxPrice = empty($maxPrice) ? null : $maxPrice;

    //     // Thực hiện truy vấn lấy sản phẩm theo giá và danh mục
    //     $filteredProducts = Product::with('categories')
    //         ->whereHas('categories', function ($query) use ($category) {
    //             $query->where('id', $category);
    //         })
    //         ->when($minPrice !== null, function ($query) use ($minPrice) {
    //             $query->where('price', '>=', $minPrice);
    //         })
    //         ->when($maxPrice !== null, function ($query) use ($maxPrice) {
    //             $query->where('price', '<=', $maxPrice);
    //         })
    //         ->get();

    //     // return response()->json(['products' => $filteredProducts]);
    //     return view('client.products.product_by_price', compact('filteredProducts'));
    // }
    // public function filterProducts(Request $request, $category)
    // {
    //     $minPrice = $request->input('min_price');
    //     $maxPrice = $request->input('max_price');

    //     // Thực hiện truy vấn lấy sản phẩm theo giá và danh mục
    //     $products = $this->product->getBy($request->all(), $category)
    //         ->whereBetween('price', [$minPrice, $maxPrice])
    //         ->get();

    //     return response()->json(['products' => $products]);
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
