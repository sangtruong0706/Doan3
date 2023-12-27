@extends('client.layouts.app')
@section('title', 'Product  ')
@section('content')

<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                @foreach ($products  as $category)
                    @php
                        $id_category = $category->categories->first()->id;
                    @endphp
                @endforeach
                <form id="filterForm{{ $id_category }}" action="{{ route('filter.products', $id_category) }}" method="POST">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="price-all">
                        <label class="custom-control-label" for="price-all">All Price</label>
                        {{-- <span class="badge border font-weight-normal">1000</span> --}}
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-1">
                        <label class="custom-control-label" for="price-1">$0 - $500</label>
                        <input type="hidden" id="min_price_1" value="0">
                        <input type="hidden" id="max_price_1" value="500">
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-2">
                        <label class="custom-control-label" for="price-2">$500 - $1000</label>
                        <input type="hidden" id="min_price_2" value="500">
                        <input type="hidden" id="max_price_2" value="1000">
                        {{-- <span class="badge border font-weight-normal">295</span> --}}
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-3">
                        <label class="custom-control-label" for="price-3">$1000 - $899500</label>
                        <input type="hidden" id="min_price_3" value="1000">
                        <input type="hidden" id="max_price_3" value="899500">
                        {{-- <span class="badge border font-weight-normal">246</span> --}}
                    </div>
                    <button type="submit" class="btn btn-primary" >Apply Filter</button>
                </form>
            </div>
            <!-- Price End -->

        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Sort by
                                    </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="#">Latest</a>
                                <a class="dropdown-item" href="#">Popularity</a>
                                <a class="dropdown-item" href="#">Best Rating</a>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($products as $item )
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src="{{ $item->images->count() > 0 ? asset('upload/'. $item->images->first()->url) : 'upload/default.jpg' }}" alt="" style="height: 478px; width: 320px !important">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{ $item->name }}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>${{ $item->price }}</h6><h6 class="text-muted ml-2"><del>${{ $item->price }}</del></h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="{{ route('client.product.show',['id'=>$item->id]) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->
{{-- <script>
    function applyFilter(category) {
    // Lấy giá trị min và max từ các hidden input
    var minPrice = $('input[id^="min_price_"]:checked').val();
    var maxPrice = $('input[id^="max_price_"]:checked').val();
    var id_category = category;

    // Gửi yêu cầu Ajax đến route đã định nghĩa với thông tin danh mục
    $.ajax({
        url: '/filter-products/' + category,
        type: 'POST',
        data: {
            min_price: minPrice,
            max_price: maxPrice,
            id_category: id_category,
        },
        headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
        success: function (data) {
            // Xử lý dữ liệu trả về, có thể cập nhật giao diện sản phẩm
            console.log(data.products);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}
</script> --}}
@endsection
