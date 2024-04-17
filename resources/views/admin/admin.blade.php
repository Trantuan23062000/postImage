<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin Post</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/home/admin/assets/img/favicon.png" rel="icon">
  <link href="/home/admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/home/admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/home/admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/home/admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/home/admin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/home/admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/home/admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/home/admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/home/admin/assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="/home/admin/assets/img/favicon.pngs" alt="">
        <span class="d-none d-lg-block">Admin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="GET">
        <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="/home/admin/assets/img/favicon.png" alt="Profile" class="rounded-circle">
            @if(Auth::check())
            <span class="d-none d-md-block dropdown-toggle ps-2">{{strtoupper(Auth::user()->username)}}</span>
            @endif
          </a><!-- End Profile Iamge Icon -->
          @if(Auth::check())
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              @if(Auth::check())
              <span class="d-none d-md-block dropdown-toggle ps-2">{{ strtoupper(Auth::user()->username) }}</span>
              @endif
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a id="logoutBtn" class="dropdown-item d-flex align-items-center">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
        @else
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>Kevin Anderson</h6>
            <span>Web Designer</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-gear"></i>
              <span>Account Settings</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
              <i class="bi bi-question-circle"></i>
              <span>Need Help?</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
        @endif


      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{route('admin')}}">
          <i class="bi bi-grid"></i>
          <span>Bảng điều khiển</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Dữ liệu</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('admin.tag')}}">
              <i class="bi bi-aspect-ratio"></i><span>Thẻ tag</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.category')}}">
              <i class="bi bi-aspect-ratio"></i><span>Loại bài viết</span>
            </a>
          </li>

          <li>
            <a href="{{route('admin.post')}}">
              <i class="bi bi-aspect-ratio"></i><span>Bài viết về hình ảnh</span>
            </a>
          </li>

          <li>
            <a href="{{route('admin.user')}}">
              <i class="bi bi-aspect-ratio"></i><span>Quản lí người dùng</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-heading">Trang</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Hồ sơ</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" id="logoutBtn">
          <i id="logoutBtn" class="bi bi-box-arrow-in-right"></i>
          <span>Đăng xuất</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <!-- <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">Bài viết</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-event"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$totalCount}}</h6>
                  <span class="text-success small pt-1 fw-bold">{{$totalDownloads}}</span> <span class="text-muted small pt-2 ps-1">Lượt tải xuống</span>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Lượt truy cập</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-chat-right-text-fill"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$view}}</h6>
                  <span class="text-success small pt-1 fw-bold">lượt xem và {{$share}} lượt chia sẽ</span> <span class="text-muted small pt-2 ps-1"></span>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">User </h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$user}}</h6>
                  <span class="text-danger small pt-1 fw-bold">Người dùng</span>

                </div>
              </div>

            </div>
          </div>

        </div><!-- End Customers Card -->

        @yield('content')


      </div>

      </div>
    </section>

  </main><!-- End #main -->



  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/home/admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/home/admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/home/admin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="/home/admin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="/home/admin/assets/vendor/quill/quill.min.js"></script>
  <script src="/home/admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/home/admin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="/home/admin/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="/home/admin/assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Template Main JS File -->
  <script>
    document.getElementById('logoutBtn').addEventListener('click', function(event) {
      event.preventDefault(); // Ngăn chặn mặc định hành vi của thẻ a

      // Gửi yêu cầu POST đến route 'logout'
      fetch('{{ route("logout") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
        })
        .then(response => {
          // Đăng xuất thành công, hiển thị thông báo
          Swal.fire({
            icon: 'success',
            title: 'Đăng xuất thành công!',
            showConfirmButton: true,
            allowOutsideClick: false // Ngăn người dùng đóng thông báo bằng cách click ra ngoài
          }).then((result) => {
            if (result.isConfirmed) {
              // Nhấn nút "OK", reload trang
              window.location.href = "{{ route('admin') }}";
            }
          });
        })
        .catch(error => {
          console.error('Đã xảy ra lỗi:', error);
        });
    });
  </script>


</body>

</html>