@extends('layouts.frontend')

@section('title', 'ตะกร้า')

@section('content')
<div class="container with-navbar mt-4">
    <!-- หัวข้อ -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-brown">ตะกร้าสินค้า</h2>
        <p class="text-muted small">เลือกหนังสือที่คุณต้องการชำระเงิน</p>
    </div>

    <!-- Layout แบ่งซ้าย-ขวา -->
    <div class="row g-4">
        <!-- รายการตะกร้า -->
        <div class="col-lg-8">
            <form id="cartForm" action="{{ route('checkout.uploadForm') }}" method="POST">
                @csrf
                <input type="hidden" name="cart_json" id="cartJson">
                <ul id="cartList" class="list-group shadow-sm rounded"></ul>
            </form>
        </div>

        <!-- สรุปยอด + ปุ่ม -->
        <div class="col-lg-4">
            <div class="card card-summary">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-brown">สรุปคำสั่งซื้อ</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">ยอดรวมทั้งหมด</span>
                        <span id="total" class="fw-bold fs-5 text-green">฿0.00</span>
                    </div>
                    <hr>
                    <!-- ปุ่มต่างๆ -->
                    <div class="d-grid gap-2">
                        <button type="button"
                            class="btn btn-green rounded-pill fw-bold py-2 shadow-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal">
                            ชำระเงิน
                        </button>
                        <a href="{{ url('/') }}"
                           class="btn btn-brown rounded-pill fw-bold py-2 shadow-sm">
                           เลือกหนังสือเพิ่มเติม
                        </a>
                        <button id="clearCart" type="button"
                            class="btn btn-red rounded-pill fw-bold py-2 shadow-sm">
                            ลบตะกร้าทั้งหมด
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal ชำระเงิน -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 bg-light-brown">
            <h5 class="mb-3 fw-bold text-brown">สแกน QR เพื่อชำระเงิน</h5>
            <div class="text-center mb-3">
                <img src="{{ asset('assets/images/qrpayment.jpg') }}" alt="QR Code"
                     class="img-fluid rounded shadow-sm qr-payment">
            </div>
            <div class="text-center mb-3">
                <span class="text-muted">ยอดชำระ</span>
                <span id="modalTotal" class="fw-bold fs-5 ms-1 text-red">฿0.00</span>
            </div>
            <p class="text-muted small text-center mb-4">
                หลังจากชำระเงินเสร็จสิ้น กรุณาคลิก <strong>"ชำระเสร็จสิ้น"</strong>
            </p>
            <div class="d-flex justify-content-between">
                <button type="submit" form="cartForm"
                        class="btn btn-green flex-fill me-2 fw-bold">
                        ชำระเสร็จสิ้น
                </button>
                <button class="btn flex-fill ms-2 btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

@if(session('paid_ids'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    const paidIds = @json(session('paid_ids'));
    clearPaidItems(paidIds);   // ✅ ล้างเฉพาะที่จ่ายแล้ว
    updateCartBadge();
    renderCart();
});
</script>
@endif




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("click", (e) => {
    if (e.target.id === "clearCart") {
        Swal.fire({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณต้องการลบตะกร้าทั้งหมด",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e57373",
            cancelButtonColor: "#574f44",
            confirmButtonText: "ใช่, ลบเลย",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem(`papery_cart_${window.appUserId}`);
                updateCartBadge();
                renderCart();

                Swal.fire({
                    title: "ลบแล้ว!",
                    text: "ตะกร้าถูกลบเรียบร้อย",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }
});
</script>
@endsection
