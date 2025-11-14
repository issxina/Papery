@extends('layouts.frontend')

@section('css_before')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection


@section('content')
<!-- 
<div class="container mt-2 with-navbar mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card card-custom">
                <div class="card-header">
                    แก้ไขข้อมูลส่วนตัว
                </div>
                <div class="card-body">
                    {{-- แสดง error --}}
                    @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" name="user_name" class="form-control"
                                value="{{ old('user_name', $user->user_name) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">เบอร์โทร</label>
                            <input type="text" name="user_phone" class="form-control"
                                value="{{ old('user_phone', $user->user_phone) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ที่อยู่</label>
                            <textarea name="user_address" class="form-control" rows="3">{{ old('user_address', $user->user_address) }}</textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                            <a href="{{ route('home') }}" class="btn btn-back">ย้อนกลับ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div> -->
<div class="container with-navbar mt-4">

    {{-- Header --}}
    <div class="profile-header card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="profile-banner"></div>

        <div class="profile-head-inner d-flex align-items-end gap-3 px-3 px-md-4">
            <div class="avatar-wrap">
                <i class="fa-solid fa-user-circle avatar"></i>
            </div>

            <div class="flex-grow-1">

                {{-- แสดงชื่อผู้ใช้ --}}
                <h2 class="display-name mb-0">
                    {{ old('user_name', $user->user_name) ?? 'User' }}
                </h2>
            </div>

        </div>
    </div>


    {{-- ฟอร์มแก้ไข (คงข้อมูล/ฟิลด์เดิม) --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ชื่อผู้ใช้--}}
                <div class="mb-3">
                    <label class="form-label form-title">ชื่อผู้ใช้</label>
                    <input type="text"
                        name="user_name"
                        value="{{ old('user_name', $user->user_name) }}"
                        class="form-control form-input @error('user_name') is-invalid @enderror"
                        placeholder="กรอกชื่อผู้ใช้">
                    @error('user_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- เบอร์โทร --}}
                <div class="mb-3">
                    <label class="form-label form-title">เบอร์โทร</label>
                    <input type="text"
                        name="user_phone"
                        value="{{ old('user_phone', $user->user_phone) }}"
                        class="form-control form-input @error('user_phone') is-invalid @enderror"
                        placeholder="กรอกเบอร์โทร">
                    @error('user_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ที่อยู่ --}}
                <div class="mb-3">
                    <label class="form-label form-title">ที่อยู่</label>
                    <textarea name="user_address"
                        rows="4"
                        class="form-control form-input @error('user_address') is-invalid @enderror"
                        placeholder="กรอกที่อยู่">{{ old('user_address', $user->user_address) }}</textarea>
                    @error('user_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ url('/') }}" class="btn btn-outline-brown px-4 rounded-pill fw-semibold">ย้อนกลับ</a>
                    <button type="submit" class="btn btn-green px-4 rounded-pill fw-bold">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection