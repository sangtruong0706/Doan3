@extends('admin.layouts.app')
@section('title', 'Product')
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
            <h6 class="text-white text-capitalize ps-3">Product list</h6>
          </div>
        </div>
        <div class="row">
            <div>
                <a class="btn btn-primary my-3" href="{{ route('product.create') }}">Create Product</a>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
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
                @foreach ($dataProduct as $pro )
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
                @endforeach

              </tbody>
            </table>
            {{ $dataProduct->links() }}
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
