@extends('home.home')
@section('content')

<section>
    <!-- Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">Chia sẻ bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="shareForm">
                        <div class="mb-3">
                            <input type="hidden" id="photoId" name="photoId">
                            <label for="emailInput" class="form-label">Địa chỉ Email</label>
                            <input type="email" class="form-control" id="emailInput" placeholder="Nhập địa chỉ email của bạn" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Chia sẻ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9" data-aos="fade-up">
            @foreach ($photos as $photo)
            @if($photo->active !== null)
            <div class="d-md-flex post-entry-2 half">
                <a href="{{ route('viewPost', ['id' => $photo->id]) }}" class="me-4 thumbnail view-photo" data-photo-id="{{ $photo->id }}">
                    <img src="{{ asset('/storage/' . $photo->image_url) }}" alt="" class="img-fluid @if($photo->status == 1) copyrighted @endif">
                </a>
                <div>
                    <div class="post-meta"><span class="date">Thời gian</span> <span class="mx-1">&bullet;</span> <span>{{$photo->created_at}}</span></div>
                    <h3>{{$photo->title}}</h3>
                    <p>{{$photo->description}}</p>
                    <div class="d-flex align-items-center author">
                        <div class="photo"><img src="/home/assets/img/favicon.png" alt="" class="img-fluid"></div>
                        <div class="name">
                            <h3 class="m-0 p-0">{{$photo->user->username}}</h3>
                        </div>
                    </div>
                    <ul class="aside-tags list-unstyled">
                        <li><a>Category:{{$photo->category->name}}</a></li>
                        <li><a>Tag:{{$photo->tag->name}}</a></li>
                        <li><a>Lượt tải:{{$photo->downloads_count}}</a></li>
                    </ul>
                    </ul>
                    <div class="post-meta mt-4">
                        <div>
                            <a href="{{ route('viewPost', ['id' => $photo->id]) }}" data-photo-id="{{ $photo->id }}" class="btn btn-primary view-photo">
                                <span>Xem bài viết</span>
                                @if ($photo->status == 1)
                                <span><i class="bi bi-eye-slash-fill"></i></span>
                                @else
                                <span><i class="bi bi-eye-fill"></i>{{$photo->views}}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    @auth
                    @if(auth()->user()->id == $photo->user_id || (auth()->user()->role == 'admin' && $photo->user_id == auth()->id()))
                    <a href="{{ route('postEdit', ['id' => $photo->id]) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button class="btn btn-danger delete-post-btn" data-id="{{ $photo->id }}"><i class="bi bi-trash-fill"></i> Delete</button>
                    @endif
                    @if(auth()->user()->role == 'admin' && $photo->user_id != auth()->user()->id)
                    <button class="btn btn-danger delete-post-btn" data-id="{{ $photo->id }}"><i class="bi bi-trash-fill"></i> Delete</button>
                    @endif

                    @endauth
                    @if ($photo->status == 0 )
                    <div class="btn-group" role="group">
                        @if(auth()->check() || $photo->status == 0 )
                        @if($photo->status == 0)
                        <a href="{{ asset('/storage/' . $photo->image_url) }}" download="image.jpg" id="downloadBtn" class="btn btn-primary" data-photo-id="{{ $photo->id }}"><i class="bi bi-download"></i> Download</a>
                        @endif
                        <a class="btn btn-info btn-share" data-photo-id="{{ $photo->id }}"><i class="bi bi-share"></i> Share</a>
                        @else
                        <button onclick="showLoginAlert()" class="btn btn-warning"><i class="bi bi-exclamation-triangle"></i> Login to Download</button>
                        <button onclick="showLoginAlert()" class="btn btn-info" data-photo-id="{{ $photo->id }}"><i class="bi bi-share"></i> Login to Share</button>
                        @endif
                    </div>
                    @else
                    <button disabled class="btn btn-secondary"><i class="bi bi-slash-circle"></i> Download disabled</button>
                    @endif


                </div>

            </div>
            @endif
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $photos->links() }}
            </div>

        </div>


        <div class="col-md-3">
            <div class="aside-block">
                <h3 class="aside-title">Categories</h3>
                <ul class="aside-links list-unstyled">
                    @foreach ( $cat as $item )
                    <li><a href="{{ route('filter.posts', ['cat' => $item->id]) }}">{{ $item->name }}</a></li>

                    @endforeach

                </ul>
            </div><!-- End Categories -->

            <div class="aside-block">
                <h3 class="aside-title">Tags</h3>
                <ul class="aside-tags list-unstyled">
                    @foreach ( $tag as $item )
                    <li><a href="{{ route('filter.posts', ['tag' => $item->id]) }}">{{ $item->name }}</a></li>
                    @endforeach
                </ul>
            </div><!-- End Tags -->

        </div>

    </div>
    </div>
    <style>
        .copyrighted {
            filter: blur(5px);
            /* Áp dụng hiệu ứng làm mờ */
            -webkit-filter: blur(10px);
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

        $(document).ready(function() {
            $('#downloadBtn').click(function() {
                var photoId = $(this).data('photo-id');

                // Gửi yêu cầu AJAX để tải hình ảnh
                $.ajax({
                    type: 'GET',
                    url: '/download/' + photoId,
                    success: function(response) {
                        // Hiển thị thông báo SweetAlert khi tải hình ảnh thành công
                        Swal.fire({
                            icon: 'success',
                            title: 'Tải hình ảnh thành công!',
                            text: 'Hình ảnh đã được tải xuống thành công.'
                        });
                        //window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Hiển thị thông báo lỗi nếu có lỗi xảy ra
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi khi tải hình ảnh.'
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            $(".view-photo").click(function(event) {
                event.preventDefault();
                var photoId = $(this).data("photo-id");
                $.get("/photos/" + photoId + "/views", function(response) {
                    console.log(response.success);
                    // Sau khi yêu cầu AJAX được xử lý thành công, điều hướng người dùng đến trang chi tiết của bài viết
                    window.location.href = "/viewPost/" + photoId;
                }).fail(function() {
                    console.error("Failed to increase views.");
                });
            });
        });



        $('.btn-share').click(function() {
            // Lấy ID của bài viết từ thuộc tính data
            var photoId = $(this).data('photo-id');
            // Mở modal
            $('#shareModal').modal('show');
            // Lưu ID của bài viết vào một trường ẩn trong modal để sử dụng sau này
            $('#shareModal').find('#photoId').val(photoId);
        });




        // Xử lý khi người dùng nhấn nút "Chia sẻ" trong modal
        $('#shareForm').submit(function(event) {
            event.preventDefault();
            // Lấy ID của bài viết từ trường ẩn trong modal
            var photoId = $('#photoId').val();
            // Lấy địa chỉ email từ trường nhập trong modal
            var email = $('#emailInput').val();
            // Gửi yêu cầu AJAX để chia sẻ bài viết
            $.ajax({
                type: 'POST',
                url: '/photos/' + photoId + '/share',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function(response) {
                    // Hiển thị thông báo SweetAlert khi chia sẻ thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Chia sẻ thành công!',
                        text: response.success
                    });
                    // Đóng modal sau khi chia sẻ thành công
                    $('#shareModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Hiển thị thông báo SweetAlert khi có lỗi xảy ra
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi chia sẻ bài viết.'
                    });
                }
            });
        });

        function showLoginAlert() {
            sessionStorage.setItem('returnUrl', window.location.href);
            Swal.fire({
                icon: 'info',
                title: 'Vui lòng đăng nhập',
                text: 'Bạn cần đăng nhập để thực hiện.',
                showCancelButton: true,
                confirmButtonText: 'Đăng nhập',
                cancelButtonText: 'Hủy',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Chuyển hướng người dùng đến trang đăng nhập
                    window.location.href = '/login';
                }
            });
        }
    </script>
</section>
@endsection