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
                    Edit Order Details
                </div>
                <div class="card-body">
                    <form action="/orderdetails/{{ $id }}" method="post">
                        @csrf
                        @method('put')

                        {{-- Order --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Order No.</label>
                            <div class="col-sm-7">
                                <select name="order_id" class="form-select" required>
                                    @foreach($orderList as $order)
                                    <option value="{{ $order->id }}" {{ old('order_id', $order_id) == $order->id ? 'selected' : '' }}>
                                        {{ $order->id }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('order_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Book --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Book</label>
                            <div class="col-sm-7">
                                <select name="book_id" id="book_id" class="form-select" required onchange="setUnitPrice()">
                                    <option value="">-- Select Book --</option>
                                    @foreach($bookList as $book)
                                    <option value="{{ $book->id }}" data-price="{{ $book->book_price }}" {{ old('book_id', $book_id) == $book->id ? 'selected' : '' }}>
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
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">QTY</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="orderdetails_qty" id="orderdetails_qty" required min="1" value="{{ old('orderdetails_qty', $orderdetails_qty) }}" oninput="calcTotalPrice()">
                                @error('orderdetails_qty')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Unit Price --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Unit Price</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="orderdetails_unit_price" id="orderdetails_unit_price" value="{{ old('orderdetails_unit_price', $orderdetails_unit_price) }}" readonly>
                            </div>
                        </div>

                        {{-- Total Price --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Total Price</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="orderdetails_total_price" id="orderdetails_total_price" value="{{ old('orderdetails_total_price', $orderdetails_total_price) }}" readonly>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="row">
                            <div class="offset-sm-3 col-sm-7">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="/orderdetails" class="btn btn-secondary">✖ Cancel</a>
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
    function setUnitPrice() {
        const bookSelect = document.getElementById('book_id');
        const price = bookSelect.options[bookSelect.selectedIndex].getAttribute('data-price');
        if (price) {
            document.getElementById('orderdetails_unit_price').value = price;
            calcTotalPrice();
        }
    }

    function calcTotalPrice() {
        const qty = parseFloat(document.getElementById('orderdetails_qty').value) || 0;
        const unit = parseFloat(document.getElementById('orderdetails_unit_price').value) || 0;
        document.getElementById('orderdetails_total_price').value = (qty * unit).toFixed(2);
    }

    window.onload = function() {
        setUnitPrice();
        calcTotalPrice();
    };
</script>
@endsection
