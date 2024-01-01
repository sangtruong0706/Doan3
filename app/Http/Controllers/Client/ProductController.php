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
    public function filterProducts(Request $request, $category)
    {
        $action_filter = $request->input('filterPrice');
        if ($action_filter == 'increase') {
            $products_filter_asc = $this->product->getByPriceAsc($category);
            // return view('client.products.product_filter_asc', compact('products_filter_asc'));
            $view = view('client.products.product_filter_asc', compact('products_filter_asc'))->render();
        } else if ($action_filter == 'decrease') {
            $products_filter_desc = $this->product->getByPriceDesc($category);
            // return view('client.products.product_filter_desc', compact('products_filter_desc'));
            $view = view('client.products.product_filter_desc', compact('products_filter_desc'))->render();

        }
        return response()->json(['view' => $view]);
    }


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
