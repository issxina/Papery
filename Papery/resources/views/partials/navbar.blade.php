<header>
    <nav class="navbar navbar-expand-lg fixed-top 
    {{ request()->is('/') ? 'navbar-hero' : 'navbar-hero navbar-dark-mode' }}"
        id="mainNavbar">

        <div class="container d-flex align-items-center">

            {{-- โลโก้ --}}
            <a class="navbar-brand fw-bold d-flex align-items-center me-4" href="{{ url('/') }}">
                <img id='logo' src="{{ asset('assets/images/papery_rmbgwhite.png') }}"
                    alt="Papery Logo" width="80">
                <span class="brand-text ms-2">Papery</span>
            </a>

            {{-- หมวดหมู่ (desktop) --}}
            <div class="d-none d-lg-flex gap-3">
                <a href="{{ url('/home/category/cartoon') }}"
                    class="categoryBtn {{ request()->is('category*') ? 'show' : 'd-none' }}">การ์ตูน</a>
                <a href="{{ url('/home/category/fiction') }}"
                    class="categoryBtn {{ request()->is('category*') ? 'show' : 'd-none' }}">นิยาย/วรรณกรรม</a>
                <a href="{{ url('/home/category/travel') }}"
                    class="categoryBtn {{ request()->is('category*') ? 'show' : 'd-none' }}">ท่องเที่ยว</a>
                <a href="{{ url('/home/category/psychology') }}"
                    class="categoryBtn {{ request()->is('category*') ? 'show' : 'd-none' }}">จิตวิทยา</a>
                <a href="{{ url('/home/category/knowledge') }}"
                    class="categoryBtn {{ request()->is('category*') ? 'show' : 'd-none' }}">ความรู้ทั่วไป</a>
            </div>

            {{-- Search --}}
            <div class="search-container ms-auto me-3">
                <form action="{{ url('/search') }}" method="GET" class="search-box">
                    <input type="search" name="keyword" id="searchInput" placeholder="ค้นหาหนังสือ..." autocomplete="off">
                    <i class="fa-solid fa-magnifying-glass search-icon" id="searchIcon"></i>
                    <button type="button" class="clear-btn" id="clearSearch">&times;</button>
                </form>
                <div class="live-search-results" id="liveResults"></div>
            </div>

            {{-- Auth + Cart (desktop) --}}
            <div class="d-none d-lg-flex align-items-center gap-3">
                @if(!Auth::guard('web')->check() && !Auth::guard('admin')->check())
                <a href="#"
                    id="loginBtn"
                    class="action_btn btn btn-light btn-sm border-1" style="border-color: #574f44;"
                    data-bs-toggle="modal"
                    data-bs-target="#authModal">
                    Login / Register
                </a>
                @endif

                @if(Auth::guard('web')->check() || Auth::guard('admin')->check())
                <div class="dropdown" id="userDropdown">
                    <button
                        class="btn btn-outline btn-sm d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user-circle"></i>
                        <span id="nickname">
                            {{ Auth::guard('admin')->check() 
                                ? Auth::guard('admin')->user()->st_name 
                                : Auth::guard('web')->user()->user_name }}
                        </span>
                        <i class="fa-solid fa-chevron-down small"></i>
                    </button>

                    {{-- Dropdown --}}
                    <div class="dropdown-menu dropdown-menu-end p-0 userpanel shadow">
                        <div class="px-3 py-3 border-bottom user-info-box">
                            <div class="fw-bold" id="userTitle">
                                {{ Auth::guard('admin')->check() 
                                    ? Auth::guard('admin')->user()->st_name 
                                    : Auth::guard('web')->user()->user_name }}
                            </div>
                            @if(Auth::guard('admin')->check())
                            <span class="badge bg-secondary">Staff</span>
                            @endif
                            <div class="text-muted small" id="userId">
                                ID: {{ Auth::guard('admin')->check() 
                                    ? Auth::guard('admin')->user()->id 
                                    : Auth::guard('web')->user()->id }}
                            </div>
                        </div>

                        @if(Auth::guard('web')->check())
                        <div class="px-3 py-3 border-bottom">
                            <a class="d-block user-item mb-2" href="{{ route('profile.edit') }}">แก้ไขข้อมูลส่วนตัว</a>
                            <a class="d-block user-item" href="{{ route('profile.history') }}">ประวัติการสั่งซื้อของฉัน</a>
                        </div>
                        @endif

                        @if(Auth::guard('admin')->check())
                        <div class="px-3 py-3 border-bottom">
                            <a class="d-block user-item" href="{{ route('dashboard') }}">Dashboard</a>
                        </div>
                        @endif

                        <div class="px-3 py-3">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="btn btn-link p-0 cart-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                    <i class="bi bi-cart"></i>
                    <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill">0</span>
                </a>
                @endif
            </div>

            {{-- Hamburger (mobile/tablet) --}}
            <button class="hamburger d-lg-none ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
</header>

<!-- {{-- Offcanvas Menu (mobile/tablet) --}}
<div class="offcanvas offcanvas-end offcanvas-custom" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">เมนู</h5>
        <button type="button" class="btn-close custom-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column">

        {{-- Categories --}}
        <a href="{{ url('/home/category/cartoon') }}" class="nav-link">การ์ตูน</a>
        <a href="{{ url('/home/category/fiction') }}" class="nav-link">นิยาย/วรรณกรรม</a>
        <a href="{{ url('/home/category/travel') }}" class="nav-link">ท่องเที่ยว</a>
        <a href="{{ url('/home/category/psychology') }}" class="nav-link">จิตวิทยา</a>
        <a href="{{ url('/home/category/knowledge') }}" class="nav-link">ความรู้ทั่วไป</a>

        <hr class="my-3">

        {{-- Admin --}}
        @if(Auth::guard('admin')->check())
        <div class="user-section mb-3">
            <div class="fw-bold d-flex align-items-center gap-2">
                <span>{{ Auth::guard('admin')->user()->st_name }}</span>
                <span class="badge bg-secondary">Staff</span>
            </div>
            <a href="{{ route('dashboard') }}" class="nav-link mt-2">Dashboard</a>
        </div>
        @endif

        {{-- Web User --}}
        @if(Auth::guard('web')->check())
        <div class="user-section mb-3">
            <span class="fw-bold d-block mb-2">{{ Auth::guard('web')->user()->user_name }}</span>
            <a href="{{ route('profile.edit') }}" class="nav-link">แก้ไขข้อมูลส่วนตัว</a>
            <a href="{{ route('profile.history') }}" class="nav-link">ประวัติการสั่งซื้อของฉัน</a>
        </div>
        @endif

        <hr class="my-3">

        {{-- Cart --}}
        <div class="cart-section mb-3">
            <a href="{{ route('cart.index') }}" class="nav-link d-flex align-items-center gap-2">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>ตะกร้า</span>
                <span id="cartBadgeMobile" class="badge ms-auto">0</span>
            </a>
        </div>



        {{-- ปุ่ม Login/Register หรือ Logout ต่อจากตะกร้า --}}
        @if(!Auth::guard('web')->check() && !Auth::guard('admin')->check())
        {{-- ยังไม่ล็อกอิน --}}
        <a href="#"
            id="loginBtnOffcanvas"
            class="btn btn-outline-light w-100"
            data-bs-toggle="modal"
            data-bs-target="#authModal">
            Login / Register
        </a>
        @endif

        @if(Auth::guard('web')->check())
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100">Logout</button>
        </form>
        @endif

        @if(Auth::guard('admin')->check())
        {{-- ถ้าโปรเจกต์ใช้ route อื่น เช่น admin.logout ให้แก้ --}}
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100">Logout</button>
        </form>
        @endif

    </div>
</div> -->

{{-- Offcanvas Menu (mobile/tablet) --}}
<div class="offcanvas offcanvas-end offcanvas-custom" tabindex="-1" id="mobileMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">เมนู</h5>
    <button type="button" class="btn-close custom-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  {{-- ใช้ UI ใหม่นี้แทนเฉพาะ body --}}
  <div class="offcanvas-body">
    {{-- Categories --}}
    <div class="oc-section">หมวดหมู่</div>
    <div class="oc-card">
      <a class="oc-link" href="{{ url('/home/category/cartoon') }}">
        <div class="oc-item">
          <div class="oc-icon"><i class="fa-solid fa-book-open"></i></div>
          <div class="oc-text">การ์ตูน</div>
          <i class="fa-solid fa-chevron-right oc-chev"></i>
        </div>
      </a>
      <a class="oc-link" href="{{ url('/home/category/fiction') }}">
        <div class="oc-item">
          <div class="oc-icon"><i class="fa-solid fa-feather"></i></div>
          <div class="oc-text">นิยาย/วรรณกรรม</div>
          <i class="fa-solid fa-chevron-right oc-chev"></i>
        </div>
      </a>
      <a class="oc-link" href="{{ url('/home/category/travel') }}">
        <div class="oc-item">
          <div class="oc-icon"><i class="fa-solid fa-map-location-dot"></i></div>
          <div class="oc-text">ท่องเที่ยว</div>
          <i class="fa-solid fa-chevron-right oc-chev"></i>
        </div>
      </a>
      <a class="oc-link" href="{{ url('/home/category/psychology') }}">
        <div class="oc-item">
          <div class="oc-icon"><i class="fa-solid fa-brain"></i></div>
          <div class="oc-text">จิตวิทยา</div>
          <i class="fa-solid fa-chevron-right oc-chev"></i>
        </div>
      </a>
      <a class="oc-link" href="{{ url('/home/category/knowledge') }}">
        <div class="oc-item">
          <div class="oc-icon"><i class="fa-solid fa-graduation-cap"></i></div>
          <div class="oc-text">ความรู้ทั่วไป</div>
          <i class="fa-solid fa-chevron-right oc-chev"></i>
        </div>
      </a>
    </div>

    {{-- Admin --}}
    @if(Auth::guard('admin')->check())
      <div class="oc-section">บัญชี</div>
      <div class="oc-card">
        <div class="oc-item">
          <div class="oc-icon"><i class="fa-solid fa-user-shield"></i></div>
          <div class="oc-text">
            {{ Auth::guard('admin')->user()->st_name }}
            <span class="oc-sub">Staff</span>
          </div>
        </div>
        <a class="oc-link" href="{{ route('dashboard') }}">
          <div class="oc-item">
            <div class="oc-icon"><i class="fa-solid fa-gauge-high"></i></div>
            <div class="oc-text">Dashboard</div>
            <i class="fa-solid fa-chevron-right oc-chev"></i>
          </div>
        </a>
      </div>
    @endif

    {{-- Web User --}}
    @if(Auth::guard('web')->check())
      <div class="oc-section">บัญชี</div>
      <div class="oc-card">
        <div class="oc-item">
          <div class="oc-icon"><i class="fa-solid fa-user"></i></div>
          <div class="oc-text">{{ Auth::guard('web')->user()->user_name }}</div>
        </div>
        <a class="oc-link" href="{{ route('profile.edit') }}">
          <div class="oc-item">
            <div class="oc-icon"><i class="fa-solid fa-id-card-clip"></i></div>
            <div class="oc-text">แก้ไขข้อมูลส่วนตัว</div>
            <i class="fa-solid fa-chevron-right oc-chev"></i>
          </div>
        </a>
        <a class="oc-link" href="{{ route('profile.history') }}">
          <div class="oc-item">
            <div class="oc-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <div class="oc-text">ประวัติการสั่งซื้อของฉัน</div>
            <i class="fa-solid fa-chevron-right oc-chev"></i>
          </div>
        </a>
      </div>
    @endif

    {{-- Cart + Auth --}}
    <div class="oc-section">การใช้งาน</div>
    <div class="oc-card">
      <a class="oc-link" href="{{ route('cart.index') }}">
        <div class="oc-item">
          <div class="oc-icon"><i class="fa-solid fa-cart-shopping"></i></div>
          <div class="oc-text">ตะกร้า</div>
          <span id="cartBadgeMobile" class="oc-badge">0</span>
        </div>
      </a>

      @if(!Auth::guard('web')->check() && !Auth::guard('admin')->check())
        <a href="#" class="oc-link" data-bs-toggle="modal" data-bs-target="#authModal">
          <div class="oc-item">
            <div class="oc-icon"><i class="fa-solid fa-right-to-bracket"></i></div>
            <div class="oc-text">Login / Register</div>
            <i class="fa-solid fa-chevron-right oc-chev"></i>
          </div>
        </a>
      @else
        <form action="{{ route('logout') }}" method="POST" class="w-100">
          @csrf
          <button type="submit" class="btn btn-outline-dark w-100 mt-2 oc-cta">Logout</button>
        </form>
      @endif
    </div>

  </div>
</div>



{{-- Scripts เดิม (live search + category scroll) --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector('.search-box input');
        const clearBtn = document.querySelector('.search-box .clear-btn');
        const resultsBox = document.getElementById('liveResults');
        const searchIcon = document.getElementById('searchIcon');

        searchInput.addEventListener('keyup', async function() {
            const query = this.value.trim();
            if (query.length < 2) {
                resultsBox.style.display = "none";
                resultsBox.innerHTML = "";
                return;
            }
            const res = await fetch(`/live-search?keyword=${encodeURIComponent(query)}`);
            const data = await res.json();

            if (data.length) {
                resultsBox.innerHTML = "<ul>" + data.map(item =>
                    `<li onclick="window.location='/search?keyword=${encodeURIComponent(item.book_title)}'">
                    <img src="/storage/${item.book_img}" alt="">
                    <span>${item.book_title}</span>
                </li>`
                ).join("") + "</ul>";
                resultsBox.style.display = "block";
            } else {
                resultsBox.style.display = "none";
            }
        });

        clearBtn.addEventListener('click', () => {
            searchInput.value = "";
            resultsBox.innerHTML = "";
            resultsBox.style.display = "none";
            searchInput.focus();
        });

        searchIcon.addEventListener("click", () => {
            searchInput.focus();
        });
    });
</script>

<script>
    document.addEventListener("scroll", function() {
        const categoryBtns = document.querySelectorAll(".categoryBtn");
        const isCategoryPage = window.location.pathname.startsWith("/home/category") || window.location.pathname.startsWith("/search");

        if (isCategoryPage) {
            categoryBtns.forEach(btn => {
                btn.classList.remove("d-none");
                btn.classList.add("show");
            });
        } else {
            if (window.scrollY > 200) {
                categoryBtns.forEach(btn => {
                    btn.classList.remove("d-none");
                    btn.classList.add("show");
                });
            } else {
                categoryBtns.forEach(btn => {
                    btn.classList.add("d-none");
                    btn.classList.remove("show");
                });
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const hamburger = document.querySelector(".hamburger");
        const offcanvas = document.getElementById("mobileMenu");

        offcanvas.addEventListener("show.bs.offcanvas", () => {
            hamburger.classList.add("is-active");
        });

        offcanvas.addEventListener("hidden.bs.offcanvas", () => {
            hamburger.classList.remove("is-active");
        });
    });
</script>