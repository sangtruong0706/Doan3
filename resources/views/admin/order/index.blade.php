@extends('admin.layouts.app')
@section('title', 'Product')
@section('content')

<div class="container-fluid pt-5">
    <div class="col">
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>status</th>
                    <th>total</th>
                    <th>ship</th>
                    <th>customer_name</th>
                    <th>customer_email</th>
                    <th>customer_address</th>
                    <th>note</th>
                    <th>payment</th>
                    <th>Action</th>
                </tr>

                @foreach ($orders as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            <div class="input-group input-group-static mb-4">
                                <select name="status" class="form-control select-status"
                                data-action="{{ route('admin.order.update_status', $item->id) }}">
                                    @foreach (config('order.status') as $status)
                                        <option value="{{ $status }}"
                                            {{ $status == $item->status ? 'selected' : '' }}>{{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>${{ $item->total }}</td>

                        <td>${{ $item->ship }}</td>
                        <td>{{ $item->customer_name }}</td>
                        <td>{{ $item->customer_email }}</td>

                        <td>{{ $item->customer_address }}</td>
                        <td>{{ $item->note }}</td>
                        <td>{{ $item->payment }}</td>
                        <td>
                            @if ($item->status == 'cancel')
                                <button class="btn btn-danger btn-delete" data-id="{{ $item->id }}">Xóa</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $orders->links() }}
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        $('.select-status').change(function () {
            var status = $(this).val();
            var url = $(this).data('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Cập nhật trạng thái thành công',
                    });
                    // Xử lý dữ liệu hoặc cập nhật giao diện tại đây (nếu cần)
                    console.log('Cập nhật trạng thái thành công');
                },
                error: function (error) {
                    console.log('Đã xảy ra lỗi: ' + error);
                }
            });
        });
        // Xử lý sự kiện khi nút xóa được nhấn
        $('.btn-delete').click(function () {
            var row = $(this).closest('tr');
            var orderId = $(this).data('id');
            var deleteUrl = '{{ route("admin.order.delete", ":id") }}'.replace(':id', orderId);

            // Hiển thị cảnh báo SweetAlert2 để xác nhận việc xóa
            Swal.fire({
                title: 'Xác nhận xóa đơn hàng',
                text: 'Bạn có chắc chắn muốn xóa đơn hàng này?',
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
                        url: deleteUrl,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            // Xử lý sau khi xóa thành công (cập nhật giao diện, thông báo, v.v.)
                            console.log('Đã xóa đơn hàng thành công');
                            // Ẩn hàng chứa đơn hàng sau khi xóa thành công
                            row.fadeOut(500, function () {
                                row.remove(); // Xóa hàng khỏi DOM
                            });

                            // Hiển thị thông báo SweetAlert2 thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Đã xóa đơn hàng thành công',
                            });
                        },
                        error: function (error) {
                            console.log('Đã xảy ra lỗi khi xóa đơn hàng: ' + error);
                        }
                    });
                }
            });
        });
    });
</script>
{{-- <script type="text/javascript">
    $(document).on('change', '.select-status',function(){
        let url = $(this).data("action");
        $.ajax({
                type: 'POST',
                url: url,
                data: {
                    'status': $(this).val();
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert()->success('Update status Successfully');
                };
    })});
</script> --}}
@endsection
