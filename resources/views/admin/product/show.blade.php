<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="productDetailModalLabel">Chi Tiết Sản Phẩm</h5>
            <button style="background: red;border: none;color: white;width: 27px;" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-6">
                    <img src="{{ $product->images ? asset('upload/'. $product->images->first()->url) : 'upload/default.jpg' }}" id="show-image" alt="" style="width: 330px; height: 427px;">
                </div>
                <div class="col-6">
                    <p class="text-bold">Tên Sản Phẩm: <span style="font-weight: 400;">{{ $product->name }} </span></p>
                    <p class="text-bold">Giá: $<span style="font-weight: 400;">{{ $product->price }}</span></p>
                    <p class="text-bold">Sale: <span style="font-weight: 400;">{{ $product->sale.'%' }}</span></p>
                    <p class="text-bold">Description: <span style="font-weight: 400;">{{ $product->description }}</span></p>
                    <hr>
                    <div style="display: flex">
                        <div class="text-bold">Category: &nbsp;</div>
                        @foreach ($product->categories as $category)
                            <div>{{ $category->name }}</div>
                        @endforeach
                    </div>
                    <div>
                        <table>
                            <thead>
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
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button> --}}
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Đóng</button>
        </div>
    </div>
</div>
    {{-- <div class="card">
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
    </div> --}}



