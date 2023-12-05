@extends('admin.layouts.app')
@section('title', 'Edit Category '.$category->name)
@section('content')
<div class="card">
    <h1>Edit Category</h1>
    <div>
        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="input-group input-group-static mb-4">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') ?? $category->name }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @if ($category->children->count()<0)

            <div class="input-group input-group-static mb-4">
                <label for="parent_id" class="ms-0">Parent Category</label>
                <select class="form-control" id="gender" name="parent_id" >
                    <option value="">----Select Parent Category----</option>
                    @foreach ($parentCategory as $item )
                    <option value="{{ $item->id }}" {{ (old('parent_id') ?? $category->parent_id)== $item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                    @endforeach
                </select>

            </div>

            @endif

            <button type="submit" class="btn btn-submit btn-primary">Submit</button>

        </form>
    </div>
</div>

@endsection
