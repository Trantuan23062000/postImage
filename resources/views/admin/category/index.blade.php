@extends('admin.admin')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="text-end mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategorymodalForm">
        Thêm mới
    </button>
</div>
<!-- Modal thêm -->
<div class="modal fade" id="addCategorymodalForm" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTagModalLabel">Thêm mới loại bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form thêm mới tag -->
                <form id="addCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="Categoryname" class="form-label">Tên loại bài viết</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModal">Chỉnh sửa loại bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form chỉnh sửa tag -->
                <form id="editCategoryForm">
                    @csrf
                    @method('PUT') <!-- Thêm phương thức PUT -->
                    <input type="hidden" id="categoryId" name="id"> <!-- Input ẩn để lưu ID tag -->
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Tên tag</label>
                        <input type="text" class="form-control" id="Categoryname" name="name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Admin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Loại bài viết</li>
    </ol>

<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($category as $cat)
        <tr>
            <th scope="row">{{ $loop->index + 1 }}</th>
            <td> {{ $cat->name }}</td>
            <td><a class="edit-cat-btn" data-id="{{ $cat->id }}"><i class="bi bi-pencil-square"></i></a><a class="delete-cat-btn" data-id="{{ $cat->id }}"><i class="bi bi-trash-fill"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Xử lý submit form thêm mới tag bằng AJAX
        $('#addCategoryForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '/admin/addCategory',
                data: formData,
                success: function(response) {
                    // Hiển thị thông báo thành công bằng Sweet Alert 2
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message,
                        showConfirmButton: true,
                        timer: 1500 // Thời gian hiển thị thông báo (miligiây)
                    });

                    // Reload trang sau khi thông báo biến mất
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    // Xử lý lỗi và hiển thị thông báo lỗi bằng Sweet Alert 2
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = Object.values(errors)[0][0];
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: errorMessage
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        // Xử lý sự kiện click vào nút chỉnh sửa category
        $('body').on('click', '.edit-cat-btn', function() {
            var categoryId = $(this).data('id');

            // Gửi yêu cầu AJAX để lấy thông tin category cần chỉnh sửa
            $.ajax({
                type: 'GET',
                url: '/admin/category/' + categoryId + '/edit',
                success: function(response) {
                    // Hiển thị dữ liệu category trong modal chỉnh sửa
                    $('#editCategoryForm #Categoryname').val(response.name);
                    $('#editCategoryForm #categoryId').val(categoryId);
                    $('#editCategoryModal').modal('show'); // Sửa đổi ID của modal
                },
                error: function(xhr) {
                    // Xử lý lỗi và hiển thị thông báo lỗi bằng Sweet Alert 2
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi tải dữ liệu category.'
                    });
                }
            });
        });

        // Xử lý submit form chỉnh sửa category bằng AJAX
        $('#editCategoryForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var categoryId = $('#categoryId').val();

            $.ajax({
                type: 'PUT',
                url: '/admin/category/' + categoryId,
                data: formData,
                success: function(response) {
                    // Hiển thị thông báo thành công bằng Sweet Alert 2
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.success,
                        showConfirmButton: true,
                        timer: 1500
                    });

                    // Reload trang sau khi thông báo biến mất
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    // Xử lý lỗi và hiển thị thông báo lỗi bằng Sweet Alert 2
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = Object.values(errors)[0][0];
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: errorMessage
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        // Xử lý sự kiện click vào nút xoá category
        $('body').on('click', '.delete-cat-btn', function() {
            var categoryId = $(this).data('id');

            // Hiển thị cảnh báo xác nhận trước khi xoá
            Swal.fire({
                title: 'Bạn chắc chắn muốn xoá?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi yêu cầu AJAX để xoá category
                    $.ajax({
                        type: 'DELETE',
                        url: '/admin/category/' + categoryId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Hiển thị thông báo thành công bằng Sweet Alert 2
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.success,
                                showConfirmButton: true,
                                timer: 1500
                            });

                            // Reload trang sau khi thông báo biến mất
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        },
                        error: function(xhr) {
                            // Xử lý lỗi và hiển thị thông báo lỗi bằng Sweet Alert 2
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = Object.values(errors)[0][0];
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
@endsection