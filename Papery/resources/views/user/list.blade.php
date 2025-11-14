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
                <span class="page-title">User Data</span>
                <a href="/user/adding" class="btn btn-add btn-sm float-end">+ Data</a>
            </h3>

            <!-- กล่องรอบตาราง -->
            <div class="card mt-3 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th width="5%">No.</th>
                                <th width="20%">Name</th>
                                <th width="20%">Email</th>
                                <th width="30%">Address</th>
                                <th width="10%">Phone</th>
                                <th width="7%">Edit</th>
                                <th width="7%">PWD</th>
                                <th width="8%">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userList as $row)
                            <tr class="text-center">
                                <td>{{ $loop->iteration + $userList->firstItem() - 1 }}</td>
                                <td class="text-start">{{ $row->user_name }}</td>
                                <td class="text-start">{{ $row->user_email }}</td>
                                <td class="text-start" title="{{ $row->user_address }}">
                                    {{ \Illuminate\Support\Str::limit($row->user_address, 40) }}
                                </td>
                                <td>{{ $row->user_phone }}</td>
                                <td>
                                    <a href="/user/{{ $row->id }}" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                                <td>
                                    <a href="/user/reset/{{ $row->id }}" class="btn btn-warning btn-sm">Reset</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteConfirm({{ $row->id }})">Delete</button>
                                    <form id="delete-form-{{ $row->id }}" action="/user/remove/{{$row->id}}" method="POST" style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- pagination --}}
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $userList->links() }}
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
@endsection