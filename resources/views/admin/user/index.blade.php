@extends('admin.admin')
@section('content')

<div class="row">
    <div class="col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Người dùng</li>
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
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal fade" id="viewPostModal" tabindex="-1" aria-labelledby="viewPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPostModalLabel">Thông tin tài khoản và bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="fw-bold" id="username"></h4>
                        <p><strong>Email:</strong> <span id="email"></span></p>
                        <p><strong>Bài viết đã đăng:</strong></p>
                        <ul id="post"></ul>
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
            <th scope="col">Tên</th>
            <th scope="col">Email</th>
            <th scope="col">Quyền</th>
            <th scope="col">Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $item)
        <tr>
            <th scope="row">{{ $loop->index + 1 }}</th>
            <td>{{ Str::limit($item->username, 10) }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->role }}</td>
            <td>
                <a class="view-post-btn" data-id="{{ $item->id }}"><i class="bi bi-box-arrow-up-right"></i></a>
                <a class="delete-user-btn" data-id="{{ $item->id }}"><i class="bi bi-trash-fill"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $users->appends(['query' => $query])->links() }}
</div>
<style>
    .post-title {
        display: none;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
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

    $(document).ready(function() {
        $('.view-post-btn').click(function() {
            var userId = $(this).data('id');

            // Gửi yêu cầu AJAX để lấy thông tin người dùng và các bài viết của họ
            $.ajax({
                type: 'GET',
                url: '/admin/showuser/' + userId,
                success: function(user) {
                    // Hiển thị thông tin người dùng
                    $('#username').text(user.username);
                    $('#email').text(user.email);

                    // Hiển thị danh sách bài viết của người dùng
                    var posts = user.photo;
                    if (posts.length > 0) {
                        var postHtml = '';
                        for (var i = 0; i < posts.length; i++) {
                            postHtml += '<p><strong>Tiêu đề:</strong> ' + posts[i].title + '</p>';
                            postHtml += '<p><strong>Nội dung:</strong> ' + posts[i].description + '</p>';
                        }
                        $('#post').html(postHtml);
                        $('#post-title').show(); // Hiển thị phần tiêu đề
                    } else {
                        $('#post').text('Người dùng chưa đăng bài viết.');
                        $('#post-title').hide(); // Ẩn phần tiêu đề
                    }

                    // Hiển thị modal
                    $('#viewPostModal').modal('show');
                },
                error: function(xhr) {
                    // Xử lý lỗi và hiển thị thông báo lỗi
                    alert('Đã xảy ra lỗi khi tải thông tin người dùng và bài viết của họ.');
                }
            });
        });
    });
</script>
@endsection