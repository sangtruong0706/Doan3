@extends('admin.layouts.app')
@section('namePage', 'Create Category')
@section('title', 'Create Category')
@section('content')
<div class="card">
    <h1>Create Category</h1>
    <div>
        <form action="{{ route('category.store') }}" method="POST">
            @csrf

            <div class="input-group input-group-static mb-4">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="parent_id" class="ms-0">Parent Category</label>
                <select class="form-control" id="gender" name="parent_id" >
                    <option value="">----Select Parent Category----</option>
                    @foreach ($parentCategory as $item )
                        <option value="{{ $item->id }}" {{ old('parent_id')== $item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                    @endforeach
                </select>

            </div>


            <button type="submit" class="btn btn-submit btn-primary">Submit</button>

        </form>
    </div>
</div>

@endsection
