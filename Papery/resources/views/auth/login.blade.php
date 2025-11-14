<!-- Auth Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 auth-modal">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-0 pb-3">
                <h5 class="text-center fw-bold mb-3 auth-title">ล็อกอินบัญชี</h5>

                <!-- Tabs -->
                <ul class="nav nav-pills justify-content-center mb-3 auth-tabs" id="authTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request()->has('register') ? '' : 'active' }}" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab">
                            เข้าสู่ระบบ
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request()->has('register') ? 'active' : '' }}" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button" role="tab">
                            สมัครสมาชิก
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Login -->
                    <div class="tab-pane fade {{ request()->has('register') ? '' : 'show active' }}" id="login-pane" role="tabpanel">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-2">
                                <input type="text" name="login" class="form-control form-control-lg auth-input" placeholder="อีเมลหรือชื่อผู้ใช้" value="{{ old('login') }}" required />
                                @error('login')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control form-control-lg auth-input" placeholder="รหัสผ่าน" required />
                                @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn auth-btn w-100 py-2 rounded-3" type="submit">เข้าสู่ระบบ</button>
                        </form>
                    </div>

                    <!-- Register -->
                    <div class="tab-pane fade {{ request()->has('register') ? 'show active' : '' }}" id="register-pane" role="tabpanel">
                        <form id="registerForm" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <input type="text" name="user_name" class="form-control form-control-lg auth-input" placeholder="ชื่อผู้ใช้" value="{{ old('user_name') }}" required>
                                @error('user_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-2">
                                <input type="email" name="user_email" class="form-control form-control-lg auth-input" placeholder="อีเมล" value="{{ old('user_email') }}" required>
                                @error('user_email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <input type="password" name="user_password" class="form-control form-control-lg auth-input" placeholder="รหัสผ่าน" required>
                                @error('user_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <textarea name="user_address" class="form-control form-control-lg auth-input" rows="3" placeholder="ที่อยู่" required>{{ old('user_address') }}</textarea>
                                @error('user_address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <input type="text" name="user_phone" class="form-control form-control-lg auth-input" placeholder="เบอร์โทร" value="{{ old('user_phone') }}" required>
                                @error('user_phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <button class="btn auth-btn w-100 py-2 rounded-3" type="submit">สร้างบัญชี</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- เปิด modal อัตโนมัติเมื่อ error --}}
@if(session('auth_error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var authModal = new bootstrap.Modal(document.getElementById('authModal'));
        authModal.show();
    });
</script>
@endif