<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Post Image</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/home/assets/img/favicon.png" rel="icon">
  <link href="/home/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/home/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/home/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="/home/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/home/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS Files -->
  <link href="/home/assets/css/variables.css" rel="stylesheet">
  <link href="/home/assets/css/main.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="{{route('allPost')}}" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>Bài viết</h1>
      </a>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="{{route('post')}}">Thêm bài viết<i class="bi bi-plus-circle"></i></a></li>
          <li><a>Thông tin</a></li>
          <li><a>Liên hệ</a></li>
          @if(Auth::check())
          <li class="dropdown"><a><span>{{strtoupper(Auth::user()->username)}}</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a>Hồ sơ</a></li>
              <li><a href="{{route('myPost')}}">Bài viết đã đăng</a></li>
              <li><a id="logoutBtn">Đăng xuất</a></li>
              <!-- <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li> -->
            </ul>
          </li>
          @else
          <li class="dropdown"><a><span>Tài khoản</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="{{route('login')}}">Đăng nhập</a></li>
              <li><a href="{{ route('home.register') }}">Đăng kí</a></li>
              <!-- <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li> -->
            </ul>
          </li>
          @endif
        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative">
        <a href="#" class="mx-2"><span class="bi-facebook"></span></a>
        <a href="#" class="mx-2"><span class="bi-twitter"></span></a>
        <a href="#" class="mx-2"><span class="bi-instagram"></span></a>

        <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
        <i class="bi bi-list mobile-nav-toggle"></i>

        <!-- ======= Search Form ======= -->
        <div class="search-form-wrap js-search-form-wrap">
          <form class="search-form" action="{{ route('search') }}" method="POST">
            <!-- Thay đổi action để điều hướng đến route phù hợp -->
            @csrf
            <span class="icon bi-search"></span>
            <input name="keyword" type="text" placeholder="Search" class="form-control">
            <button class="btn js-search-close" type="submit"></button>
            <button class="btn js-search-close" type="submit"><i class="bi bi-arrow-right-square"></i></button>
          </form>
        </div><!-- End Search Form -->
      </div>

    </div>

  </header><!-- End Header -->
  <main id="main">
    @yield('content')
    @yield('mypost')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer footer footer-small">

    <div class="footer-legal">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <div class="copyright">
              © Copyright <strong><span>2024</span></strong>. An Giang University
            </div>

          </div>

          <div class="col-md-6">
            <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

        </div>

      </div>
    </div>

  </footer>


  <!-- Vendor JS Files -->
  <script src="/home/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/home/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/home/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/home/assets/vendor/aos/aos.js"></script>
  <script src="/home/assets/vendor/php-email-form/validate.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Template Main JS File -->
  <script src="/home/assets/js/main.js"></script>
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
              window.location.reload();
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