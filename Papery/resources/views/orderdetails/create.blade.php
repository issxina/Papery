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
                    Add Order Details
                </div>
                <div class="card-body">
                    <form action="/orderdetails" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- Order --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Order No.</label>
                            <div class="col-sm-7">
                                <select name="order_id" class="form-select" required>
                                    <option value="">-- Select Order --</option>
                                    @foreach($orderList as $order)
                                    <option value="{{ $order->id }}" {{ old('order_id')==$order->id ? 'selected' : '' }}>
                                        Order #{{ $order->id }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('order_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Book --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Book</label>
                            <div class="col-sm-7">
                                <select name="book_id" id="book_id" class="form-select" required onchange="setUnitPrice()">
                                    <option value="">-- Select Book --</option>
                                    @foreach($bookList as $book)
                                    <option value="{{ $book->id }}" data-price="{{ $book->book_price }}" {{ old('book_id')==$book->id ? 'selected' : '' }}>
                                        {{ $book->book_title }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('book_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Qty --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Qty</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="orderdetails_qty" id="orderdetails_qty"
                                    required min="1" value="{{ old('orderdetails_qty', 1) }}" oninput="calcTotalPrice()">
                                @error('orderdetails_qty')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Unit Price --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Unit Price</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="orderdetails_unit_price"
                                    id="orderdetails_unit_price" required value="{{ old('orderdetails_unit_price') }}"
                                    oninput="calcTotalPrice()" readonly>
                                @error('orderdetails_unit_price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Total Price --}}
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Total Price</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="orderdetails_total_price"
                                    id="orderdetails_total_price" required value="{{ old('orderdetails_total_price') }}" readonly>
                                @error('orderdetails_total_price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="row">
                            <div class="offset-sm-3 col-sm-7">
                                <button type="submit" class="btn btn-primary me-2">Insert</button>
                                <a href="/orderdetails" class="btn btn-secondary">✖ Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setUnitPrice() {
        let bookSelect = document.getElementById('book_id');
        let price = bookSelect.options[bookSelect.selectedIndex]?.getAttribute('data-price');
        if (price) {
            document.getElementById('orderdetails_unit_price').value = price;
            calcTotalPrice();
        }
    }

    function calcTotalPrice() {
        let qty = parseFloat(document.getElementById('orderdetails_qty').value) || 0;
        let unit = parseFloat(document.getElementById('orderdetails_unit_price').value) || 0;
        document.getElementById('orderdetails_total_price').value = (qty * unit).toFixed(2);
    }

    window.onload = function() {
        setUnitPrice();
        calcTotalPrice();
    };
</script>

@endsection