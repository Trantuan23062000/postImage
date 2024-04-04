<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Register</title>
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
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">{{ __('Login') }}</h5>
                                    </div>

                                    <form id="loginForm" class="row g-3" method="POST" action="{{route('postLogin')}}" novalidate>
                                        @csrf

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Email</label>
                                            <div class="input-group">
                                                <input type="email" name="email" class="form-control" id="email">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control" id="password">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">{{ __('Login') }}</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="{{route('home.register')}}">Create an account</a></p>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Quên mật khẩu <a href="{{route('forgot')}}">Click</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Template Main JS File -->
    <script src="/home/admin/assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
       $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("postLogin") }}',
                data: formData,
                success: function(response) {
                    // Xử lý phản hồi thành công
                    Swal.fire({
                        icon: 'success',
                        text: response.success,
                    });
                    $(window).on('click', function() {
                    window.location.href = "{{ route('allPost') }}";
                    });
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value + '<br>';
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mật khẩu và email không đúng !',
                        html: errorMessage,
                    });
                }
            });
        });
    });
    </script>

</body>

</html>