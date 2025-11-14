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

            <!-- หัวข้อ -->
            <h3>
                <span class="page-title">Category Data</span>
                <a href="/category/adding" class="btn btn-add btn-sm float-end">+ Data</a>
            </h3>

            <!-- กล่องรอบตาราง -->
            <div class="card mt-3 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="35%">Name</th>
                                <th width="35%">Name Eng</th>
                                <th width="10%">Edit</th>
                                <th width="10%">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categoryList as $row)
                            <tr class="text-center">
                                <td>{{ $loop->iteration + $categoryList->firstItem() - 1 }}</td>
                                <td class="text-start">{{ $row->category_name }}</td>
                                <td class="text-start">{{ $row->category_slug }}</td>
                                <td>
                                    <a href="/category/{{ $row->id }}" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteConfirm({{ $row->id }})">Delete</button>
                                    <form id="delete-form-{{ $row->id }}" action="/category/remove/{{$row->id}}" method="POST" style="display: none;">
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
                        {{ $categoryList->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_before')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteConfirm(id) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: "หากลบแล้วจะไม่สามารถกู้คืนได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#8dba98',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
