@extends('admin.layouts.app')
@section('namePage', 'List Roles')
@section('title', 'Roles')
@section('content')
<div class="row">
    <div class="col-12">
        @if (session('messages'))
            <div class="alert alert-success text-white my-3" role="alert">
                <strong>Success!</strong> {{ session('messages') }}
            </div>
        @endif
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Role list</h6>
          </div>
        </div>
        <div class="row">
            <div>
                <a class="btn btn-primary my-3" href="{{ route('roles.create') }}">Create Role</a>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Display Name</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($roles as $role )
                <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $role->id }}</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $role->name }}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success">{{ $role->display_name }}</span>
                    </td>
                    <td class="align-middle" style="display: flex; justify-content: center; align-items: center; margin-top: 24px;">
                      <a style="margin-right: 12px;" href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">
                        Edit
                      </a>
                      <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit">Delete</button>

                        </form>
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
            {{ $roles->links() }}
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
