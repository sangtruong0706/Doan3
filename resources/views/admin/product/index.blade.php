@extends('admin.layouts.app')
@section('namePage', 'List Product')
@section('title', 'Product')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Product list</h6>
          </div>
        </div>
        <div class="row">
            <div>
                <a class="btn btn-primary my-3" href="{{ route('product.create') }}">Create Product</a>
            </div>
        </div>
        <!-- Modal Hiển Thị Chi Tiết Sản Phẩm -->
        <div class="modal fade " id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productDetailModalLabel">Chi Tiết Sản Phẩm</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Tên Sản Phẩm: <span id="productName"></span></p>
                        <p>Giá: $<span id="productPrice"></span></p>
                        <!-- ... (thêm các thông tin khác) -->
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button> --}}
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="product-table">
              <thead>
                <tr>
                  <th class="text-secondary opacity-7">#</th>
                  <th class="text-secondary opacity-7">Image</th>
                  <th class="text-secondary opacity-7">Name</th>
                  <th class="text-secondary opacity-7">Price</th>
                  <th class="text-secondary opacity-7">Sale</th>
                  <th class="text-secondary opacity-7">Action</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach ($dataProduct as $pro )
                <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $pro->id }}</h6>
                        </div>
                      </div>
                    </td>
                    <td class="text-xs font-weight-bold mb-0">
                        <img src="{{ $pro->images->count() > 0 ? asset('upload/'. $pro->images->first()->url) : 'upload/default.jpg' }}" alt="" style="width: 150px; height:140px;">
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $pro->name }}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold mb-0">{{ $pro->price }}</span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold mb-0">{{ $pro->sale }}</span>
                    </td>
                    <td class="align-middle" style="display: flex; ">
                      <a href="{{ route('product.edit', $pro->id) }}" class="btn btn-sm btn-warning">
                        Edit
                      </a>
                      <a href="{{ route('product.show', $pro->id) }}" class="btn btn-info">
                        <i style="width: 20px" class="bi bi-eye-fill"></i>
                      </a>
                      <form action="{{ route('product.destroy', $pro->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>

                        </form>
                    </td>
                  </tr>
                @endforeach --}}
              </tbody>
            </table>
            {{-- {{ $dataProduct->links() }} --}}
          </div>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function closeModal() {
    myModal.hide();
    }
    function deleteProduct(productId) {
    Swal.fire({
        title: 'Xác nhận xóa sản phẩm',
        text: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Gửi yêu cầu xóa đến server khi xác nhận
            $.ajax({
                type: 'DELETE',
                url: 'http://127.0.0.1:8000/product/' + productId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    // Hiển thị thông báo SweetAlert2 thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Đã xóa sản phẩm thành công',
                    });
                    location.reload();
                },
                error: function (error) {
                    console.log('Đã xảy ra lỗi khi xóa sản phẩm: ' + error);
                }
            });
        }
    });
    }
    function showProduct(productId) {
        // Gửi yêu cầu lấy chi tiết sản phẩm từ server
        $.ajax({
            type: 'GET',
            url: 'http://127.0.0.1:8000/product/' + productId,
            success: function (data) {
                if (data.view) {
                    $('#productDetailModal').html(data.view);
                    $('#productDetailModal').modal('show');
                }

            },
            error: function (error) {
                console.log('Đã xảy ra lỗi khi lấy chi tiết sản phẩm: ' + error);
            }
        });
    }
    $(document).ready(function() {
        $('#product-table').DataTable({
            ajax: {
            url: "{{ route('get.product.admin') }}",
            dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                {
                    data: 'images',
                    render: function(data) {
                        // return data.length;
                        return '<img src="' + '{{ asset('upload/') }}/' + data[0].url + '" alt="Product Image" style="width: 150px; height:140px;">';
                    }
                },
                { data: 'name' },
                { data: 'price' },
                { data: 'sale' },
                {
                    data: 'id',
                    render: function(id) {
                        let showButton = '<button class="btn btn-info btn-sm" onclick="showProduct(' + id + ')">Show</button>';

                        // Thêm nút Sửa
                        let editButton = '<a href="http://127.0.0.1:8000/product/' + id + '/edit" class="btn btn-warning btn-sm">Sửa</a>';

                        // Thêm nút Xóa
                        let deleteButton = '<button class="btn btn-danger btn-sm" onclick="deleteProduct(' + id + ')">Xóa</button>';

                        // Kết hợp các nút vào một chuỗi HTML
                        return showButton + ' ' + editButton + ' ' + deleteButton;
                    }
                },
                // {
                //     data: null,
                //     render: function(data, type, row) {
                //         return '<button class="btn btn-danger" onClick="deleteProduct(' + row.id + ')">Xóa</button>';
                //     }
                // },
            ]
        });
        // Hàm sửa sản phẩm
        function editProduct(productId) {
            // Chuyển đến route product.edit với ID sản phẩm
            window.location.href = "{{ url('product') }}/" + productId + "/edit";
        }
        // Hàm xóa sản phẩm


    });
</script>
@endsection
