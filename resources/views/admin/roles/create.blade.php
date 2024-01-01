@extends('admin.layouts.app')
@section('namePage', 'Create Role')
@section('title', 'Create Role')
@section('content')
<div class="card">
    <h1>Create Role</h1>
    <div>
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="input-group input-group-static mb-4">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Display Name</label>
                <input type="text" class="form-control" name="display_name" value="{{ old('display_name') }}">
                @error('display_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label for="exampleFormControlSelect1" class="ms-0">Group</label>
                <select class="form-control" id="exampleFormControlSelect1" name="group">
                  <option value="system">System</option>
                  <option value="user">User</option>
                </select>
                @error('group')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Permission</label>
                <div class="row">
                    @foreach ($permission as $groupName => $permission)
                    <div class="col-md-5">
                        <div>
                            <h4>{{ $groupName }}</h4>
                        </div>
                        <div>
                            @foreach ($permission as $item )
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" name="permission_ids[]">
                                <label class="custom-control-label" for="customCheck1">{{ $item->display_name }}</label>
                              </div>
                            @endforeach
                        </div>
                    </div>

                @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-submit btn-primary">Submit</button>

        </form>
    </div>
</div>

@endsection
