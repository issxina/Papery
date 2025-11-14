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

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card card-custom">
                <div class="card-header">
                    Update Order
                </div>
                <div class="card-body">
                    <form action="/order/{{ $id }}" method="post">
                        @csrf
                        @method('put')

                        {{-- User --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">User</label>
                            <div class="col-sm-7">
                                <select name="user_id" class="form-control" required>
                                    <option value="">-- Select User --</option>
                                    @foreach($userList as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->user_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Status</label>
                            <div class="col-sm-7">
                                <select name="order_status" class="form-control" required>
                                    @php
                                        $statuses = ['pending','paid','packed','shipped','completed','cancelled'];
                                    @endphp
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ old('order_status', $order_status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_status')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Subtotal --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Subtotal</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="order_subtotal"
                                       required placeholder="Subtotal" value="{{ old('order_subtotal', $order_subtotal) }}">
                                @error('order_subtotal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Discount --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Discount</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="order_discount"
                                       required placeholder="Discount" value="{{ old('order_discount', $order_discount) }}">
                                @error('order_discount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        {{-- Order Date --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Date</label>
                            <div class="col-sm-7">
                                <input type="datetime-local" class="form-control" name="order_date" required
                                       value="{{ old('order_date', \Carbon\Carbon::parse($order_date)->format('Y-m-d\TH:i')) }}">
                                @error('order_date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Shipping Address --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Address</label>
                            <div class="col-sm-7">
                                <textarea class="form-control" name="order_shipping_address" rows="2" required
                                          placeholder="Address">{{ old('order_shipping_address', $order_shipping_address) }}</textarea>
                                @error('order_shipping_address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="row">
                            <div class="offset-sm-3 col-sm-7">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
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

@section('js_after')
<script>
    // auto update amount preview
    const subtotalEl = document.querySelector('[name="order_subtotal"]');
    const discountEl = document.querySelector('[name="order_discount"]');
    const amountEl   = document.getElementById('order_amount');

    function updateAmount() {
        const subtotal = parseFloat(subtotalEl.value) || 0;
        const discount = parseFloat(discountEl.value) || 0;
        amountEl.value = (subtotal - discount).toFixed(2);
    }

    subtotalEl.addEventListener('input', updateAmount);
    discountEl.addEventListener('input', updateAmount);
</script>
@endsection
