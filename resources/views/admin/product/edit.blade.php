@extends('admin.layouts.app')
@section('title', 'Edit Product')
@section('content')
    <div class="card">
        <h1>Edit Product</h1>

        <div>
            <form action="{{ route('product.update', $product->id) }}" method="post" id="createForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class=" input-group-static col-5 mb-4">
                        <label>Image</label>
                        <input type="file" accept="image/*" name="image" id="image-input" class="form-control">
                        @error('image')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-5">
                        {{-- <img src="" id="show-image" alt="" width="300px"> --}}
                        <img src="{{ $product->images ? asset('upload/'. $product->images->first()->url) : 'upload/default.jpg' }}" id="show-image" alt="" style="width: 150px; height:150px; border-radius:50%">
                    </div>
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" value="{{ old('name') ?? $product->name }}" name="name" class="form-control">

                    @error('name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Price</label>
                    <input type="number" step="0.1" value="{{ old('price') ?? $product->price  }}" name="price" class="form-control">
                    @error('price')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Sale</label>
                    <input type="number" value="0" value="{{ old('sale')?? $product->sale  }}" name="sale" class="form-control">
                    @error('sale')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>



                <div class="form-group">
                    <label>Description</label>
                    <div class="row w-100 h-100">
                        <textarea name="description" id="description" class="form-control" cols="4" rows="5"
                            style="width: 100%">{{ old('description')?? $product->description  }} </textarea>
                    </div>
                    @error('description')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                {{-- <input type="hidden" id="inputSize" name='sizes'> --}}
                <!-- Button trigger modal -->
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSizeModal">
                    Add size
                </button> --}}
                <div>
                    <p>Add size</p>
                    {{-- <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="S" name="size_ids[]">
                        <label class="custom-control-label" for="customCheck1">S</label>
                        <!-- Ô input số lượng cho size S -->
                        <input type="number" name="quantity_S" placeholder="Quantity for S">
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="M" name="size_ids[]">
                        <label class="custom-control-label" for="customCheck1">M</label>
                        <!-- Ô input số lượng cho size M -->
                        <input type="number" name="quantity_M" placeholder="Quantity for M">
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="L" name="size_ids[]">
                        <label class="custom-control-label" for="customCheck1">L</label>
                        <!-- Ô input số lượng cho size L -->
                        <input type="number" name="quantity_L" placeholder="Quantity for L">
                    </div> --}}
                    @foreach ($allSizes as $size)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $size }}" name="size_ids[]" @if(in_array($size, array_column($quantityArray, 'size'))) checked @endif>
                            <label class="custom-control-label" for="customCheck1">{{ $size }}</label>
                            <!-- Ô input số lượng cho từng size -->
                            @php
                                $sizeKey = array_search($size, array_column($quantityArray, 'size'));
                                $quantityValue = ($sizeKey !== false) ? $quantityArray[$sizeKey]['quantity'] : 0;
                                // print_r($quantityValue);
                            @endphp
                            <input type="number" name="quantity_{{ $size }}" value="{{ $quantityValue }}" placeholder="Quantity for {{ $size }}">
                        </div>
                        </div>
                     @endforeach
                </div>


        </div>
        <div class="input-group input-group-static mb-4">
            <label name="group" class="ms-0">Category</label>
            <select name="category_ids[]" class="form-control" multiple>
                @foreach ($category as $item)
                    <option value="{{ $item->id}}" {{ $product->categories->contains('id',$item->id) ? 'selected' : ''  }} >{{ $item->name }}</option>
                @endforeach
            </select>

            @error('category_ids')
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-submit btn-primary">Submit</button>
        </form>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
    <script>
    $(() => {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#show-image').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image-input").change(function() {
            readURL(this);
        });



    });
    </script>
@endsection


