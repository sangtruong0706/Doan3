@extends('admin.layouts.app')
@section('namePage', 'Edit Coupons')
@section('title', 'Edit Coupon '.$coupon->name)
@section('content')
<div class="card">
    <h1>Edit Coupon</h1>
    <div>
        <form action="{{ route('coupon.update', $coupon->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="input-group input-group-static mb-4">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') ?? $coupon->name }}" style="text-transform: uppercase">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Value</label>
                <input type="number" class="form-control" name="value" value="{{ old('value') ?? $coupon->value }}">
                @error('value')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="type" class="ms-0">Type</label>
                <select class="form-control" id="type" name="type">
                    <option value="" {{ old('type', $coupon->type) == '' ? 'selected' : '' }}>----Select Type----</option>
                    <option value="money" {{ old('type', $coupon->type) == 'money' ? 'selected' : '' }}>Money</option>
                </select>
                @error('type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Date expery</label>
                <input type="date" class="form-control" name="expery_date" value="{{ old('expery_date', $coupon->expery_date ? \Carbon\Carbon::parse($coupon->expery_date)->format('Y-m-d') : '') }}">
                @error('expery_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <button type="submit" class="btn btn-submit btn-primary">Submit</button>

        </form>
    </div>
</div>

@endsection
