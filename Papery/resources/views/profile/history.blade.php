@extends('layouts.frontend')

@section('title', 'ประวัติการสั่งซื้อ')

@section('css_before')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container with-navbar mt-4">
    <h3 class="fw-bold text-center mb-4">ประวัติการสั่งซื้อของฉัน</h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ url('/') }}" class="btn btn-back">ย้อนกลับ</a>
    <div class="custom-pagination">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>


    @if($orders->isEmpty())
    <div class="alert alert-info text-center shadow-sm rounded-3">
        ยังไม่มีคำสั่งซื้อ
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead>
                <tr>
                    <th>รหัสคำสั่งซื้อ</th>
                    <th>วันที่สั่ง</th>
                    <th>สถานะ</th>
                    <th>ยอดรวม</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="fw-bold">#{{ $order->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                    <td>
                        @php
                        $statusClass = [
                        'pending' => 'secondary',
                        'paid' => 'info',
                        'packed' => 'primary',
                        'shipped' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        ];
                        @endphp
                        <span class="badge bg-{{ $statusClass[$order->order_status] ?? 'secondary' }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td class="fw-bold text-green">฿{{ number_format($order->order_amount, 2) }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse"
                            data-bs-target="#details-{{ $order->id }}">
                            ดูรายละเอียด
                        </button>
                    </td>
                </tr>
                <tr class="collapse bg-light" id="details-{{ $order->id }}">
                    <td colspan="5" class="text-start">
                        <ul class="mb-0">
                            @foreach($order->details as $detail)
                            <li>
                                <strong>{{ $detail->book->book_title ?? 'Unknown' }}</strong>
                                × {{ $detail->orderdetails_qty }}
                                (฿{{ number_format($detail->orderdetails_unit_price,2) }})
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
