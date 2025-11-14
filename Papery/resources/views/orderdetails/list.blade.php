@extends('home')

@section('css_before')
<style>
    .page-title {
        display: inline-block;
        background: #498259;
        color: #fff;
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 1.5rem;
        font-weight: 600;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
    }

    /* ปุ่มเพิ่ม */
    .btn-add {
        background: #8dba98;
        border: none;
        color: #574f44;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-add:hover {
        background: #498259;
        color: #fff;
    }


    /* ตารางหัว */
    .table thead tr {
        background-color: #574f44 !important;
        color: #fff !important;
    }

    .table thead th {
        background-color: #574f44 !important;
        color: #fff !important;
    }

    /* ปุ่มแก้ไข */
    .btn-warning {
        background: #f7f4ed;
        border: 1px solid #498259;
        color: #574f44;
    }

    .btn-warning:hover {
        background: #498259;
        color: #fff;
    }

    /* ปุ่มลบ */
    .btn-danger {
        background: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background: #b52d3c;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    .pagination .page-item .page-link {
        border-radius: 6px;
        margin: 0 3px;
        padding: 6px 12px;
        color: #574f44;
        border: 1px solid #dee2e6;
        transition: 0.3s;
    }

    .pagination .page-item .page-link:hover {
        background-color: #8dba98;
        color: #fff;
        border-color: #8dba98;
    }

    .pagination .page-item.active .page-link {
        background-color: #498259;
        border-color: #498259;
        color: #fff;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .pagination .page-item.disabled .page-link {
        color: #999;
        background: #f5f5f5;
        border-color: #ddd;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">

            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="px-3 py-2 rounded-pill text-white page-title">
                    Order Details Data
                </h4>
                <a href="/orderdetails/adding" class="btn btn-add btn-sm float-end">+ Data</a>
            </div>

            <!-- Table -->
            <div class="card mt-3 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th width="5%">No.</th>
                                <th width="15%">Order No.</th>
                                <th width="20%">Book</th>
                                <th width="10%">QTY</th>
                                <th width="10%">Unit Price</th>
                                <th width="10%">Total Price</th>
                                <th width="5%">Edit</th>
                                <th width="5%">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderdetailsList as $row)
                            <tr class="text-center">
                                <td>{{ $loop->iteration + $orderdetailsList->firstItem() - 1 }}</td>
                                <td>{{ $row->order->id ?? '-' }}</td>
                                <td class="text-start">{{ $row->book->book_title ?? '-' }}</td>
                                <td>{{ $row->orderdetails_qty }}</td>
                                <td>{{ number_format($row->orderdetails_unit_price, 2) }}</td>
                                <td>{{ number_format($row->orderdetails_total_price, 2) }}</td>
                                <td>
                                    <a href="/orderdetails/{{ $row->id }}" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteConfirm({{ $row->id }})">Delete</button>
                                    <form id="delete-form-{{ $row->id }}" action="/orderdetails/remove/{{$row->id}}" method="POST" style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $orderdetailsList->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteConfirm(id) {
            Swal.fire({
                title: 'ยืนยันการลบข้อมูล',
                text: "หากลบแล้วจะไม่สามารถกู้คืนได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>