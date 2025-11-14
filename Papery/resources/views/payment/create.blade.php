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
        background: #574f44;
        /* น้ำตาลเข้มตามธีม */
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
        <div class="col-lg-8 col-md-10">

            <div class="card card-custom">
                <div class="card-header">
                    Add Payment
                </div>
                <div class="card-body">
                    <form action="/payment" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- Order --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Order</label>
                            <div class="col-sm-7">
                                <select name="order_id" class="form-control" required>
                                    <option value="">-- Select Order --</option>
                                    @foreach($orderList as $order)
                                    <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                        Order #{{ $order->id }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('order_id')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Method --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Method</label>
                            <div class="col-sm-7">
                                <select name="pay_method" class="form-control" required>
                                    <option value="">-- Select Method --</option>
                                    <option value="promptpay" {{ old('pay_method')=='promptpay'?'selected':'' }}>Promptpay</option>
                                    <!-- <option value="cod" {{ old('pay_method')=='cod'?'selected':'' }}>COD</option>
                                    <option value="bank_transfer" {{ old('pay_method')=='bank_transfer'?'selected':'' }}>Bank Transfer</option> -->
                                </select>
                                @error('pay_method')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Amount --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Amount</label>
                            <div class="col-sm-7">
                                <input type="number" step="0.01" class="form-control" name="pay_amount" required
                                    value="{{ old('pay_amount') }}" placeholder="Enter amount">
                                @error('pay_amount')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Proof --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Proof</label>
                            <div class="col-sm-7">
                                <input type="file" class="form-control" name="pay_proof_path">
                                @error('pay_proof_path')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Paid At --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Paid At</label>
                            <div class="col-sm-7">
                                <input type="datetime-local" class="form-control" name="pay_paid_at"
                                    value="{{ old('pay_paid_at') }}" required>
                                @error('pay_paid_at')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="row">
                            <div class="offset-sm-3 col-sm-7">
                                <button type="submit" class="btn btn-primary me-2">Insert</button>
                                <a href="/payment" class="btn btn-secondary">✖ Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@endsection

@section('js_before')
@endsection