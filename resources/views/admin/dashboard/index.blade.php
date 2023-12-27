@extends('admin.layouts.app')
@section('content')
<div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">weekend</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Số lượng sản phẩm bán được</p>
          <h4 class="mb-0">{{ $totalSoldQuantity }}</h4>
        </div>
      </div>
      <hr class="dark horizontal my-0">
    </div>
  </div>
  <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">person</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Tổng doang thu</p>
          <h4 class="mb-0">${{ $totalRevenue }}</h4>
        </div>
      </div>
    </div>
  </div>
@endsection
