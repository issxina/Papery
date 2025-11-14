<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Papery</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Chart.js --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      background: #f7f4ed;
      font-family: "Poppins", "Noto Sans Thai", sans-serif;
      color: #574f44;
    }

    /* Sidebar */
    .sidebar {
      background: #574f44;
      color: #fff;
      min-height: 100vh;
      padding: 20px 15px;
      border-radius: 20px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar h4 {
      font-weight: bold;
      color: #f7f4ed;
    }

    .sidebar h4:hover {
      font-weight: bold;
      color: #574f44;
    }

    .sidebar a {
      color: #f7f4ed;
      display: block;
      margin: 8px 0;
      padding: 10px 14px;
      border-radius: 10px;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .sidebar a.active,
    .sidebar a:hover {
      background: #8dba98;
      color: #574f44;
      font-weight: 600;
    }

    /* Card */
    .card-box {
      border-radius: 15px;
      border: none;
      background: #fff;
      box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.08);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-box:hover {
      transform: translateY(-3px);
      box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
    }

    .card-box .card-title {
      color: #498259;
      font-weight: 600;
    }

    /* Logout */
    .sidebar a.logout {
      background: #dc3545;
      color: #fff !important;
      margin-top: 2rem;
      font-weight: 600;
    }

    .sidebar a.logout:hover {
      background: #b52d3c;
      color: #fff !important;
      font-weight: 600;
    }

    /* Main content */
    .main-content {
      padding: 20px;
    }
  </style>
  @yield('css_before')
</head>

<body>
  <div class="container-fluid p-4 border-0">
    <div class="row">

      {{-- Sidebar --}}
      <div class="col-md-3 col-lg-2 sidebar">
        <a href="/">
          <h4 class="text-center">Papery</h4>
        </a>
        <a href="/dashboard" class="active">Dashboard</a>
        <a href="/staff">Staff</a>
        <a href="/user">Users</a>
        <a href="/category">Category</a>
        <a href="/book">Books</a>
        <a href="/order">Orders</a>
        <a href="/orderdetails">Order Details</a>
        <a href="/payment">Payment</a>
        <a href="#" class="logout"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
      </div>

      {{-- Main content --}}
      <div class="col-md-9 col-lg-10 main-content">
        @yield('content')
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @yield('js_before')
  @include('sweetalert::alert')
</body>

</html>