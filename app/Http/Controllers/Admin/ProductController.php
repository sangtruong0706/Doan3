<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\ProductDetail;
use Laravel\Prompts\Prompt;

class ProductController extends Controller
{
    protected $product, $category, $productDetail;
    public function __construct(Product $product, Category $category, ProductDetail $productDetail)
    {
        $this->product = $product;
        $this->category = $category;
        $this->productDetail = $productDetail;
    }
    public function index()
    {
        $dataProduct = $this->product::latest('id')->paginate(5);
        return view('admin.product.index', compact('dataProduct'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = $this->category::get(['id', 'name']);
        return view('admin.product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $dataCreate = $request->except('size_ids', 'quantity_S', 'quantity_M', 'quantity_L');
        $product = Product::create($dataCreate);


        $dataCreate['image'] = $this->product->saveImage($request);


        $product->images()->create(['url' => $dataCreate['image']]);


        $product->categories()->attach($dataCreate['category_ids']);

        $size_ids = $request->input('size_ids');

        $sizeArray = [];

        foreach ($size_ids as $size) {
            // Nhận giá trị của ô input số lượng tương ứng với từng size
            $quantity = $request->input('quantity_' . $size, 0);

            // Thêm vào mảng mới với key là "size" và "quantity"
            $sizeArray[] = ['size' => $size, 'quantity' => $quantity, 'product_id' => $product->id];
        }
        $this->productDetail->insert($sizeArray);

        return redirect()->route('product.index')->with(['messages' => 'Create product successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        $category = $this->category::get(['id', 'name']);
        // Danh sách các size mà bạn muốn hiển thị
        $allSizes = ['S', 'M', 'L'];
        // Lấy dữ liệu số lượng từ bảng product_details
        $quantityArray = $this->productDetail->where('product_id', $product->id)->get(['size', 'quantity'])->toArray();

        return view('admin.product.edit', compact('category', 'product', 'quantityArray', 'allSizes'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $dataUpdate = $request->except('size_ids', 'quantity_S', 'quantity_M', 'quantity_L');
        $product = $this->product->findOrFail($id);
        $product->update($dataUpdate);

        $currentImage = $product->images ? $product->images->first()->url : '';
        $dataUpdate['image'] = $this->product->updateImage($request, $currentImage);
        // $dataUpdate['image'] = $this->product->saveImage($request);
        $product->images()->delete();
        $product->images()->create(['url' => $dataUpdate['image']]);


        $product->categories()->sync($dataUpdate['category_ids']);

        $size_ids = $request->input('size_ids');

        $sizeArray = [];

        foreach ($size_ids as $size) {
            // Nhận giá trị của ô input số lượng tương ứng với từng size
            $quantity = $request->input('quantity_' . $size, 0);

            // Thêm vào mảng mới với key là "size" và "quantity"
            $sizeArray[] = ['size' => $size, 'quantity' => $quantity, 'product_id' => $product->id];
        }
        $product->details()->delete();
        $this->productDetail->insert($sizeArray);

        return redirect()->route('product.index')->with(['messages' => 'Update product successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->product->findOrFail($id);
        $product->delete();
        $product->details()->delete();
        $imageName = $product->images->count()>0 ? $product->images->first()->url : '';
        $this->product->deleteImage( $imageName);
        return redirect()->route('product.index')->with(['messages' => 'Delete product successfully']);

    }
}
