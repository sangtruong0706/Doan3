@extends('admin.layouts.app')
@section('namePage', 'Create Product')
@section('title', 'Create Product')
@section('content')
    <div class="card">
        <h1>Create Product</h1>

        <div>
            <form action="{{ route('product.store') }}" method="post" id="createForm" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class=" input-group-static col-5 mb-4">
                        <label>Image</label>
                        <input type="file" accept="image/*" name="image" id="image-input" class="form-control">
                        @error('image')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-5">
                        <img src="" id="show-image" alt="" style="width: 150px; height: 200px;">
                    </div>
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control">

                    @error('name')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Price</label>
                    <input type="number" step="0.1" value="{{ old('price') }}" name="price" class="form-control">
                    @error('price')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Sale</label>
                    <input type="number" value="0" value="{{ old('sale') }}" name="sale" class="form-control">
                    @error('sale')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>



                <div class="form-group">
                    <label>Description</label>
                    <div class="row w-100 h-100">
                        <textarea name="description" id="description" class="form-control" cols="4" rows="5"
                            style="width: 100%">{{ old('description') }} </textarea>
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
                    <div class="form-check">
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
                    </div>
                </div>

                <!-- Modal -->
                {{-- <div class="modal fade" id="AddSizeModal" tabindex="-1" aria-labelledby="AddSizeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddSizeModalLabel">Add size</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="AddSizeModalBody">

                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn  btn-primary btn-add-size">Add</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
        </div>
        <div class="input-group input-group-static mb-4">
            <label name="group" class="ms-0">Category</label>
            <select name="category_ids[]" class="form-control" >
                <option value="">---Select the category---</option>
                @foreach ($category as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>

            @error('category_ids')
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-submit btn-primary my-3">Submit</button>
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


