@extends('admin.layouts.app')
@section('namePage', 'List Coupons')
@section('title', 'Coupon')
@section('content')
<div class="row">
    <div class="col-12">
        @if (session('messages'))
        <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
            <span class="alert-icon align-middle">
              <span class="material-icons text-md">
              thumb_up_off_alt
              </span>
            </span>
            <span class="alert-text"><strong>Success!</strong> {{ session('messages') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Coupon list</h6>
          </div>
        </div>
        <div class="row">
            <div>
                <a class="btn btn-primary my-3" href="{{ route('coupon.create') }}">Create Coupon</a>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Value</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date expery</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($coupons as $item )
                <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $item->id }}</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $item->type }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $item->value }}</p>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->expery_date)->format('Y-m-d') }}</p>

                    </td>
                    <td class="align-middle" style="display: flex; justify-content: center; align-items: center; margin-top: 24px;">
                      <a style="margin-right: 12px;" href="{{ route('coupon.edit', $item->id) }}" class="btn btn-warning">
                        Edit
                      </a>
                      <form action="{{ route('coupon.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit">Delete</button>

                        </form>
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
            {{ $coupons->links() }}
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
