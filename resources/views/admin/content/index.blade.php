@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bài viết</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6">
        <div class="search-bar mt-3 mb-3 d-flex justify-content-end">
            <form id="searchForm" class="search-form form-inline" method="GET">
                <div class="input-group">
                    <input id="searchInput" type="text" class="form-control" name="query" placeholder="Nhập từ khóa tìm kiếm">
                    <button type="submit" class="btn btn-primary" title="Search"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div><!-- End row -->
<!-- Modal xem bài viết -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="modal fade" id="viewPostModal" tabindex="-1" aria-labelledby="viewPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPostModalLabel">Chi Tiết Bài Viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="postImage" class="img-fluid rounded" alt="Ảnh Bài Viết">
                    </div>
                    <div class="col-md-6">
                        <h4 id="postTitle" class="fw-bold"></h4>
                        <p class="mb-1"><strong>Người Đăng:</strong> <span id="postAuthor"></span></p>
                        <p><strong>Mô Tả:</strong></p>
                        <p id="postDescription"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<table id="dataTable" class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Loại</th>
            <th scope="col">Thẻ</th>
            <th scope="col">Người đăng</th>
            <th scope="col">Ảnh</th>
            <th scope="col">kiểm duyệt</th>
            <th scope="col">Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <th scope="row">{{ $loop->index + 1 }}</th>
            <td>{{ Str::limit($post->title, 10) }}</td>
            <td>{{ $post->category->name }}</td>
            <td>{{ $post->tag->name }}</td>
            <td>{{ $post->user->username }}</td>
            <td>
                <img src="/storage/{{ $post->image_url }}" alt="Ảnh bài viết" width="100">
            </td>
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" data-id="{{ $post->id }}" @if(is_null($post->active)) @else checked @endif>
                </div>
            </td>
            <td>
                <a class="view-post-btn" data-id="{{ $post->id }}"><i class="bi bi-box-arrow-up-right"></i></a>
                <a class="delete-post-btn" data-id="{{ $post->id }}"><i class="bi bi-trash-fill"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $posts->links() }}
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.view-post-btn').click(function() {
            var postId = $(this).data('id');

            // Gửi yêu cầu AJAX để lấy thông tin bài viết
            $.ajax({
                type: 'GET',
                url: '/admin/post/' + postId,
                success: function(post) {
                    // Cập nhật nội dung của modal với dữ liệu trả về từ server
                    $('#postTitle').text(post.title);
                    $('#postDescription').text(post.description);
                    $('#postAuthor').text(post.user.username);
                    $('#postImage').attr('src', '/storage/' + post.image_url);
                    // Hiển thị modal
                    $('#viewPostModal').modal('show');
                },
                error: function(xhr) {
                    // Xử lý lỗi và hiển thị thông báo lỗi
                    alert('Đã xảy ra lỗi khi tải nội dung bài viết.');
                }
            });
        });
    });

    $(document).ready(function() {
        $('.form-check-input').change(function() {
            var postId = $(this).data('id');
            var active = this.checked ? 1 : null;
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Gửi yêu cầu AJAX với token CSRF
            $.ajax({
                type: 'POST',
                url: '/admin/active',
                data: {
                    id: postId,
                    active: active,
                    // Bao gồm token CSRF trong dữ liệu yêu cầu
                    _token: csrfToken
                },
                success: function(response) {
                    // Kiểm tra nếu trạng thái không thay đổi
                    if (active === null) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Thông báo!',
                            text: 'Bài viết đã trở về trạng thái chờ phê duyệt !.'
                        });
                    } else {
                        // Hiển thị thông báo thành công
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.success
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi nếu cần
                }
            });
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
                        url: '/admin/deletePost/' + postId,
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
        $('#searchInput').on('keyup', function() {
            var query = $(this).val().trim().toLowerCase();

            // Lặp qua từng dòng trong bảng dữ liệu
            $('#dataTable tbody tr').each(function() {
                var username = $(this).find('td:eq(1)').text().toLowerCase(); // Thay index bằng vị trí cột của username

                // Kiểm tra xem tên người dùng có chứa từ khóa tìm kiếm không
                if (username.includes(query)) {
                    $(this).show(); // Hiển thị dòng nếu tìm thấy kết quả
                } else {
                    $(this).hide(); // Ẩn dòng nếu không tìm thấy kết quả
                }
            });



        });
    });
</script>
@endsection