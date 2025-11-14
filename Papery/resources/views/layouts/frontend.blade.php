<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/x-icon" href="assets/images/papery_logo.png" />
  <title>Papery - ร้านหนังสืออนไลน์</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Noto+Sans+Thai:wght@400;600&display=swap" rel="stylesheet">

  {{-- Custom CSS --}}
  <link href="{{ asset('css/site.css') }}" rel="stylesheet">

  {{-- Custom JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  @yield('css_before')
  

  <!-- Start navbar -->
  @include('partials.navbar')
  <!-- End navbar -->

  <!-- Start Book -->
  @yield('content')
  <!-- End Book -->

  <!-- Start Footer -->
  @include('partials.footer')
  <!-- End Footer -->

  <!-- Auth Modal -->
  @include('auth.login')

  <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer" style="z-index: 1100;">
    <div id="cartToast" class="toast align-items-center" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          เพิ่มลงตะกร้าเรียบร้อยแล้ว!
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>


  @if(session('auth_error'))
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var myModal = new bootstrap.Modal(document.getElementById('authModal'));
      myModal.show();
    });
  </script>
  @endif

  @include('sweetalert::alert')

  <!-- ส่ง userId จาก Laravel มาที่ JS -->
  <script>
    @php
    $userId = auth('web') -> id() ?? auth('admin') -> id();
    @endphp
    window.appUserId = "{{ $userId }}";
  </script>
  <script src="{{ asset('js/cart.js') }}"></script>

  <script>
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar-hero');
      const logo = document.getElementById('logo');

      // toggle class scrolled
      navbar.classList.toggle('scrolled', window.scrollY > 50);

      // เปลี่ยนโลโก้
      if (window.scrollY > 50) {
        logo.src = "{{ asset('assets/images/papery_rmbg.png') }}";
      } else {
        logo.src = "{{ asset('assets/images/papery_rmbgwhite.png') }}";
      }
    });
  </script>


  <script>
    const backToTop = document.getElementById("backToTop");
    const circle = document.querySelector(".progress-ring__circle");
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;
    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = circumference;

    function setProgress(percent) {
      const offset = circumference - (percent / 100) * circumference;
      circle.style.strokeDashoffset = offset;
    }

    window.addEventListener("scroll", () => {
      let scrollPos = window.scrollY;
      let docHeight = document.documentElement.scrollHeight - window.innerHeight;
      let scrollPercent = (scrollPos / docHeight) * 100;

      if (scrollPos > 300) {
        backToTop.style.display = "flex";
      } else {
        backToTop.style.display = "none";
      }

      setProgress(scrollPercent);
    });

    backToTop.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    function showCartToast(message = "✅ เพิ่มลงตะกร้าแล้ว!") {
      const container = document.getElementById("toastContainer");

      // ถ้า container ยังไม่มี → สร้างขึ้นมา
      if (!container) {
        const newContainer = document.createElement("div");
        newContainer.className = "toast-container position-fixed top-0 end-0 p-3";
        newContainer.id = "toastContainer";
        newContainer.style.zIndex = "1100";
        document.body.appendChild(newContainer);
      }

      // Element ของ toast
      let toastEl = document.createElement("div");
      toastEl.className = "toast align-items-center mb-2";
      toastEl.setAttribute("role", "alert");
      toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

      document.getElementById("toastContainer").appendChild(toastEl);

      // แสดง toast
      let toast = new bootstrap.Toast(toastEl, {
        delay: 3000, // 3 วิ แล้วหายเอง
        autohide: true
      });
      toast.show();

      // ลบออกจาก DOM หลังซ่อน
      toastEl.addEventListener("hidden.bs.toast", () => {
        toastEl.remove();
      });
    }

    document.addEventListener("click", function(e) {
      if (e.target.classList.contains("add-to-cart")) {
        e.preventDefault();
        showCartToast("เพิ่มลงตะกร้าแล้ว!");
      }
    });
  </script>



</body>


</html>