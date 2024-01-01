@extends('admin.layouts.app')
@section('namePage', 'Create Coupons')
@section('title', 'Create Coupon')
@section('content')
<div class="card">
    <h1>Create Coupon</h1>
    <div>
        <form action="{{ route('coupon.store') }}" method="POST">
            @csrf

            <div class="input-group input-group-static mb-4">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" style="text-transform: uppercase">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Value</label>
                <input type="number" class="form-control" name="value" value="{{ old('value') }}">
                @error('value')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="type" class="ms-0">Type</label>
                <select class="form-control" id="type" name="type">
                    <option value="" {{ old('type') == '' ? 'selected' : '' }}>----Select Type----</option>
                    <option value="money" {{ old('type') == 'money' ? 'selected' : '' }}>Money</option>
                </select>
                @error('type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Date expery</label>
                <input type="date" class="form-control" name="expery_date" value="{{ old('expery_date') }}">
                @error('expery_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <button type="submit" class="btn btn-submit btn-primary">Submit</button>

        </form>
    </div>
</div>

@endsection
