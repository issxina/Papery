@extends('home')

@section('css_before')
<style>
    /* Card style */
    .card-custom {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
        background: #fff;
    }

    .card-header {
        background: #574f44; /* น้ำตาลเข้มตามธีม */
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        padding: 15px 20px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .form-label {
        font-weight: 500;
        color: #574f44;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #8dba98;
    }

    .form-control:focus {
        border-color: #498259;
        box-shadow: 0 0 0 0.2rem rgba(141, 186, 152, 0.4);
    }

    .btn-primary {
        background: #498259;
        border: none;
        color: #fff;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: #8dba98;
        color: #fff;
    }

    .btn-secondary {
        background: #f7f4ed;
        border: 1px solid #574f44;
        color: #574f44;
        transition: 0.3s;
    }
    .btn-secondary:hover {
        background: #574f44;
        color: #fff;
    }

    .text-danger {
        font-size: 14px;
    }
</style>
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="card card-custom">
                <div class="card-header">
                    Add Order
                </div>
                <div class="card-body">
                    <form action="/order" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- User --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">User</label>
                            <div class="col-sm-7">
                                <select name="user_id" class="form-select" required>
                                    <option value="">-- Select User --</option>
                                    @foreach($userList as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->user_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Order Status --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-7">
                                <select name="order_status" class="form-select" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="pending" {{ old('order_status')=='pending'?'selected':'' }}>Pending</option>
                                    <option value="paid" {{ old('order_status')=='paid'?'selected':'' }}>Paid</option>
                                    <option value="packed" {{ old('order_status')=='packed'?'selected':'' }}>Packed</option>
                                    <option value="shipped" {{ old('order_status')=='shipped'?'selected':'' }}>Shipped</option>
                                    <option value="completed" {{ old('order_status')=='completed'?'selected':'' }}>Completed</option>
                                    <option value="cancelled" {{ old('order_status')=='cancelled'?'selected':'' }}>Cancelled</option>
                                </select>
                                @error('order_status')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Subtotal --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Subtotal</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="order_subtotal"
                                    placeholder="Subtotal" value="{{ old('order_subtotal', 0) }}" required>
                                @error('order_subtotal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Discount --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Discount</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="order_discount"
                                    placeholder="Discount" value="{{ old('order_discount', 0) }}" required>
                                @error('order_discount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Order Date --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-7">
                                <input type="datetime-local" class="form-control" name="order_date"
                                    value="{{ old('order_date') }}" required>
                                @error('order_date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Shipping Address --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-7">
                                <textarea name="order_shipping_address" class="form-control" rows="3" required
                                    placeholder="Enter address">{{ old('order_shipping_address') }}</textarea>
                                @error('order_shipping_address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Buttons --}}
                        <div class="row">
                            <div class="offset-sm-3 col-sm-7">
                                <button type="submit" class="btn btn-primary me-2">Insert</button>
                                <a href="/order" class="btn btn-secondary">✖ Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection