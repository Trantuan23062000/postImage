@extends('home')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-9" data-aos="fade-up">
                <h3 class="category-title">Category: Business</h3>
                @foreach ($photos as $photo)
                <div class="d-md-flex post-entry-2 half">
                    <a href="single-post.html" class="me-4 thumbnail">
                        <img src="{{ asset('/storage/' . $photo->image_url) }}" alt="" class="img-fluid @if($photo->status == 1) copyrighted @endif">
                    </a>
                    <div>
                        <div class="post-meta"><span class="date">Culture</span> <span class="mx-1">&bullet;</span> <span>{{$photo->created_at}}</span></div>
                        <h3>{{$photo->title}}</h3>
                        <p>{{$photo->description}}</p>
                        <div class="d-flex align-items-center author">
                            <div class="photo"><img src="/home/assets/img/favicon.png" alt="" class="img-fluid"></div>
                            <div class="name">
                                <h3 class="m-0 p-0">{{$photo->user->username}}</h3>
                            </div>
                        </div>
                        <div class="post-meta mt-4">
                            <div>
                                <a href="{{ route('viewPost', ['id' => $photo->id]) }}" class="button"><span>Xem bài viết

                                </span>@if ($photo->status == 1)
                            <span><i class="bi bi-eye-slash-fill"></i></span>
                            @else
                            <span><i class="bi bi-eye-fill"></i></span>
                            @endif</a>
                            </div>
                        </div>
                        @auth <!-- Kiểm tra người dùng đã đăng nhập hay chưa -->
                        @if(auth()->user()->id == $photo->user_id) <!-- Kiểm tra xem người đăng nhập có phải là tác giả của bài viết không -->
                        <a href="{{ route('postEdit', ['id' => $photo->id]) }}"><i class="bi bi-pencil-square"></i></a>
                        <a class="delete-post-btn" data-id="{{ $photo->id }}"><i class="bi bi-trash-fill"></i></a>
                        @endif
                        @endauth
                    </div>
                </div>
                @endforeach

                <div class="text-start py-4">
                    <div class="custom-pagination">
                        <a href="#" class="prev">Prevous</a>
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#" class="next">Next</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- ======= Sidebar ======= -->
                <div class="aside-block">

                    <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-popular-tab" data-bs-toggle="pill" data-bs-target="#pills-popular" type="button" role="tab" aria-controls="pills-popular" aria-selected="true">Popular</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-trending-tab" data-bs-toggle="pill" data-bs-target="#pills-trending" type="button" role="tab" aria-controls="pills-trending" aria-selected="false">Trending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-latest-tab" data-bs-toggle="pill" data-bs-target="#pills-latest" type="button" role="tab" aria-controls="pills-latest" aria-selected="false">Latest</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        <!-- Popular -->
                        <div class="tab-pane fade show active" id="pills-popular" role="tabpanel" aria-labelledby="pills-popular-tab">
                            <div class="post-entry-1 border-bottom">
                                <div class="post-meta"><span class="date">Sport</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                                <h2 class="mb-2"><a href="#">How to Avoid Distraction and Stay Focused During Video Calls?</a></h2>
                                <span class="author mb-3 d-block">Jenny Wilson</span>
                            </div>
                        </div> <!-- End Popular -->

                        <!-- Trending -->
                        <div class="tab-pane fade" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">
                            <div class="post-entry-1 border-bottom">
                                <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                                <h2 class="mb-2"><a href="#">17 Pictures of Medium Length Hair in Layers That Will Inspire Your New Haircut</a></h2>
                                <span class="author mb-3 d-block">Jenny Wilson</span>
                            </div>
                        </div> <!-- End Trending -->

                        <!-- Latest -->
                        <div class="tab-pane fade" id="pills-latest" role="tabpanel" aria-labelledby="pills-latest-tab">
                            <div class="post-entry-1 border-bottom">
                                <div class="post-meta"><span class="date">Lifestyle</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
                                <h2 class="mb-2"><a href="#">Life Insurance And Pregnancy: A Working Mom’s Guide</a></h2>
                                <span class="author mb-3 d-block">Jenny Wilson</span>
                            </div>
                        </div> <!-- End Latest -->

                    </div>
                </div>
                <div class="aside-block">
                    <h3 class="aside-title">Categories</h3>
                    <ul class="aside-links list-unstyled">
                        <li><a href="category.html"><i class="bi bi-chevron-right"></i> Business</a></li>
                        <li><a href="category.html"><i class="bi bi-chevron-right"></i> Culture</a></li>
                        <li><a href="category.html"><i class="bi bi-chevron-right"></i> Sport</a></li>
                        <li><a href="category.html"><i class="bi bi-chevron-right"></i> Food</a></li>
                        <li><a href="category.html"><i class="bi bi-chevron-right"></i> Politics</a></li>
                        <li><a href="category.html"><i class="bi bi-chevron-right"></i> Celebrity</a></li>
                        <li><a href="category.html"><i class="bi bi-chevron-right"></i> Startups</a></li>
                        <li><a href="category.html"><i class="bi bi-chevron-right"></i> Travel</a></li>
                    </ul>
                </div><!-- End Categories -->

                <div class="aside-block">
                    <h3 class="aside-title">Tags</h3>
                    <ul class="aside-tags list-unstyled">
                        <li><a href="category.html">Business</a></li>
                        <li><a href="category.html">Culture</a></li>
                        <li><a href="category.html">Sport</a></li>
                        <li><a href="category.html">Food</a></li>
                        <li><a href="category.html">Politics</a></li>
                        <li><a href="category.html">Celebrity</a></li>
                        <li><a href="category.html">Startups</a></li>
                        <li><a href="category.html">Travel</a></li>
                    </ul>
                </div><!-- End Tags -->

            </div>

        </div>
    </div>
    <style>
    .copyrighted {
        filter: blur(5px);
        /* Áp dụng hiệu ứng làm mờ */
        -webkit-filter: blur(5px);
        /* Áp dụng hiệu ứng làm mờ cho trình duyệt webkit-based */
        opacity: 0.7;
        /* Giảm độ sáng */
    }

</style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

        // $(document).ready(function() {
        //   $('#searchForm').submit(function(e) {
        //     e.preventDefault();
        //     var formData = $(this).serialize();

        //     $.ajax({
        //       type: 'GET',
        //       url: '/search',
        //       data: formData,
        //       dataType: 'json',
        //       success: function(response) {
        //         // Xử lý kết quả tìm kiếm và hiển thị trên trang
        //       },
        //       error: function(xhr, status, error) {
        //         console.error(xhr.responseText);
        //       }
        //     });
        //   });
        // });

        $(document).ready(function() {
            $('.delete-post-btn').click(function(e) {
                e.preventDefault();
                var postId = $(this).data('id');

                Swal.fire({
                    title: 'Bạn chắc chắn muốn xóa bài viết này?',
                    text: "Hành động này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/deletePost/' + postId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: response.success
                                }).then(function() {
                                    window.location.reload(); // Tải lại trang sau khi xóa thành công
                                });
                            },
                            error: function(xhr) {
                                var errorMessage = xhr.responseJSON.error;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</section>
@endsection