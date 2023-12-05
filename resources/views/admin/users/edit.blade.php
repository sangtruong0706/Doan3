@extends('admin.layouts.app')
@section('title', 'Edit User'.$user->name)
@section('content')
<div class="card">
    <h1>Create Role</h1>
    <div>
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class=" input-group-static mb-4 col-md-5">
                    <label>Image</label>
                    <input type="file" accept="image/*" id="image-input" class="form-control" name="image" >
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-5">
                    <img src="{{ $user->images ? asset('upload/users'. $user->images->first()->url) : 'upload/users/default.jpg' }}" id="show-image" alt="" style="width: 150px; height:150px; border-radius:50%">
                </div>
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') ?? $user->name }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') ?? $user->email }}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') ?? $user->phone }}">
                @error('phone')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Address</label>
                <textarea name="address"  class="form-control" cols="30" rows="5">{{ old('address')?? $user->address }}</textarea>
                @error('address')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Password</label>
                <input type="password" class="form-control" name="password" >
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="gender" class="ms-0">Gender</label>
                <select class="form-control" id="gender" name="gender" value="{{  $user->gender }}">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
                @error('gender')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Permission</label>
                <div class="row">
                    @foreach ($roles as $groupName => $role)
                    <div class="col-md-12">
                        <div class="row">
                            <h5>{{ $groupName }}</h5>
                        </div>
                        <div>
                            @foreach ($role as $item )
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" name="role_ids[]"
                                {{ $user->roles->contains('id', $item->id) ? 'checked' : '' }}>
                                <label name="role_name" class="custom-control-label" for="customCheck1">{{ $item->display_name }}</label>
                              </div>
                            @endforeach
                        </div>
                    </div>

                @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-submit btn-primary">Update</button>

        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
crossorigin="anonymous"></script>
<script>
$(() => {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#show-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image-input").change(function() {
        readURL(this);
    });



});
</script>

@endsection
