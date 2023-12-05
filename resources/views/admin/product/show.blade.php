@extends('admin.layouts.app')
@section('title', 'Show Product')
@section('content')
    <div class="card">
        <h1>Show Product</h1>

        <div>

                <div class="row">
                    <div class=" input-group-static col-5 mb-4">
                        <div class="text-bold">Image</div>
                    </div>
                    <div >
                        <img src="{{ $product->images ? asset('upload/'. $product->images->first()->url) : 'upload/default.jpg' }}" id="show-image" alt="" style="width: 150px; height:150px; border-radius:50%">
                    </div>
                </div>

                <div style="display: flex">
                    <div class="text-bold">Name: &nbsp; </div>
                    <div class=""> {{ $product->name }}</div>
                </div>
                <div style="display: flex">
                    <div class="text-bold">Price: &nbsp;</div>
                    <div class=""> {{ $product->price }}</div>
                </div>
                <div style="display: flex">
                    <div class="text-bold">Sale: &nbsp;</div>
                    <div class=""> {{ $product->sale.'%' }}</div>
                </div>
                <div style="display: flex">
                    <div class="text-bold">Description: &nbsp;</div>
                    <div class=""> {{ $product->description }}</div>
                </div>

        </div>
        <div style="display: flex">
            <div class="text-bold">Category: &nbsp;</div>
            @foreach ($product->categories as $category)
                <div>{{ $category->name }}</div>
            @endforeach
        </div>
        <div>
            <table>
                <thead>
                    <tr class="text-bold">Size and Quantity:</tr>
                    <tr>
                        <th>Size</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->details as $detail)
                        <tr>
                            <td>{{ $detail->size }}</td>
                            <td>{{ $detail->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>

@endsection


