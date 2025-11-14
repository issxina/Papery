
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
        <div class="col-lg-6 col-md-8">

            <div class="card card-custom">
                <div class="card-header">
                    Reset Staff Password
                </div>
                <div class="card-body">
                    <form action="/staff/reset/{{ $id }}" method="post">
                        @csrf
                        @method('put')

                        {{-- Name (disabled) --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="st_name" disabled
                                       value="{{ $st_name }}">
                            </div>
                        </div>

                        {{-- Email (disabled) --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Email</label>
                            <div class="col-sm-7">
                                <input type="email" class="form-control" name="st_email" disabled
                                       value="{{ $st_email }}">
                            </div>
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">New Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" name="st_password" required
                                       placeholder="New Password (min 4 characters)">
                                @error('st_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-end">Confirm Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" name="st_password_confirmation" required
                                       placeholder="Confirm Password">
                                @error('st_password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="row">
                            <div class="offset-sm-3 col-sm-7">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="/staff" class="btn btn-secondary">✖ Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

