<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;
    public function __construct(Category $category){
        $this->category = $category;
    }

    public function index()
    {
        $dataCategory = $this->category->latest('id')->paginate(5);
        return view('admin.category.index', compact('dataCategory'));
    }


    public function create()
    {
        $parentCategory = $this->category->getParents();
        return view('admin.category.create', compact('parentCategory'));
    }


    public function store(CreateCategoryRequest $request)
    {
        $dataCreate = $request->all();
        $category  = $this->category->create($dataCreate);
        toastr()->success('Create successfully');
        return to_route('category.index')->with(['messages'=> 'Create successfully']);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $category = $this->category->with('children')->findOrFail($id);
        $parentCategory = $this->category->getParents();
        return view('admin.category.edit', compact('category', 'parentCategory'));
    }


    public function update(UpdateCategoryRequest $request, string $id)
    {
        $dataUpdate = $request->all();
        $category = $this->category->findOrFail($id);
        $category->update($dataUpdate);
        toastr()->success('Update successfully');
        return to_route('category.index')->with(['messages'=> 'Update successfully']);
    }


    public function destroy(string $id)
    {
        $category = $this->category->findOrFail($id);
        $category->delete();
        toastr()->success('Delete successfully');
        return to_route('category.index')->with(['messages'=> 'Delete successfully']);
    }
}
