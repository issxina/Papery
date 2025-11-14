@extends('layouts.frontend')

@section('title', 'อัปโหลดสลิปการชำระเงิน')

@section('content')
<div class="container with-navbar mt-4">

  <!-- หัวข้อ -->
  <div class="text-center mb-5">
    <h3 class="fw-bold text-brown">อัปโหลดสลิปการชำระเงิน</h3>
    <p class="text-muted small">กรุณาอัปโหลดสลิปการโอนเพื่อยืนยันการชำระเงิน</p>
  </div>

  <!-- รายการที่เลือก -->
  <div class="card shadow-sm rounded-3 mb-4">
    <div class="card-header bg-light-brown fw-bold text-brown">
      รายการที่เลือกชำระ
    </div>
    <ul class="list-group list-group-flush">
      @php $total = 0; @endphp
      @foreach($cart as $item)
      @php
      $sum = $item['price'] * $item['qty'];
      $total += $sum;
      @endphp
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <span class="fw-bold text-brown">{{ $item['title'] }}</span>
          <span class="text-muted small"> (x{{ $item['qty'] }})</span>
        </span>
        <span class="fw-bold text-green">฿{{ number_format($sum, 2) }}</span>
      </li>
      @endforeach
    </ul>
    <div class="card-footer d-flex justify-content-between fw-bold">
      <span class="text-brown">รวมทั้งหมด</span>
      <span class="text-red">฿{{ number_format($total, 2) }}</span>
    </div>
  </div>

  <!-- ฟอร์มอัปโหลดสลิป -->
  <div class="card shadow-sm rounded-3 bg-light-brown mb-4">
    <div class="card-body">
      <form action="{{ route('checkout.uploadSlip') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label for="slip" class="form-label fw-bold text-brown">เลือกไฟล์สลิป</label>
          <input type="file"
            class="form-control @error('slip') is-invalid @enderror"
            id="slip"
            name="slip"
            accept="image/*" required>
          @error('slip')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Preview Slip -->
        <div id="previewContainer" class="text-center mb-3" style="display:none;">
          <p class="fw-bold text-brown small">ตัวอย่างสลิป</p>
          <img id="previewSlip" class="img-fluid rounded shadow-sm border qr-payment" alt="Preview Slip">
        </div>

        <div class="text-center mt-4 d-flex gap-2 justify-content-center">
          <button type="submit" class="btn btn-green px-4 py-2 rounded-pill fw-bold shadow-sm">
            อัปโหลด & ยืนยัน
          </button>
          <a href="{{ route('cart.index') }}" class="btn btn-brown px-4 py-2 rounded-pill fw-bold shadow-sm">
            ยกเลิก
          </a>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Script Preview Slip -->
<script>
  document.getElementById('slip').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const preview = document.getElementById('previewSlip');
      const container = document.getElementById('previewContainer');
      preview.src = URL.createObjectURL(file);
      container.style.display = 'block';
    }
  });
</script>


@endsection