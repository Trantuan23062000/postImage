@extends('admin.admin')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="text-end mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTagModal">
        Thêm mới
    </button>
</div>
<!-- Modal thêm -->
<div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTagModalLabel">Thêm mới tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form thêm mới tag -->
                <form id="addTagForm">
                    @csrf
                    <div class="mb-3">
                        <label for="tagName" class="form-label">Tên tag</label>
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
<div class="modal fade" id="editTagModal" tabindex="-1" aria-labelledby="editTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTagModalLabel">Chỉnh sửa tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form chỉnh sửa tag -->
                <form id="editTagForm">
                    @csrf
                    @method('PUT') <!-- Thêm phương thức PUT -->
                    <input type="hidden" id="editTagId" name="id"> <!-- Input ẩn để lưu ID tag -->
                    <div class="mb-3">
                        <label for="tagName" class="form-label">Tên tag</label>
                        <input type="text" class="form-control" id="tagName" name="name">
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
        <li class="breadcrumb-item active" aria-current="page">Thẻ tag </li>
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
        @foreach($tags as $tag)
        <tr>
            <th scope="row">{{ $loop->index + 1 }}</th>
            <td> {{ $tag->name }}</td>
            <td><a class="edit-tag-btn" data-id="{{ $tag->id }}"><i class="bi bi-pencil-square"></i></a><a class="delete-cat-btn"data-id="{{ $tag->id }}" ><i class="bi bi-trash-fill"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Xử lý submit form thêm mới tag bằng AJAX
        $('#addTagForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '/admin/addTag',
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
    // Xử lý sự kiện click vào nút chỉnh sửa tag
    $('body').on('click', '.edit-tag-btn', function() {
        var tagId = $(this).data('id');
        
        // Gửi yêu cầu AJAX để lấy thông tin tag cần chỉnh sửa
        $.ajax({
            type: 'GET',
            url: '/admin/tags/' + tagId + '/edit',
            success: function(response) {
                // Hiển thị dữ liệu tag trong modal chỉnh sửa
                $('#editTagModal #tagName').val(response.name);
                $('#editTagModal #editTagId').val(tagId);
                $('#editTagModal').modal('show');
            },
            error: function(xhr) {
                // Xử lý lỗi và hiển thị thông báo lỗi bằng Sweet Alert 2
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Đã xảy ra lỗi khi tải dữ liệu tag.'
                });
            }
        });
    });

    // Xử lý submit form chỉnh sửa tag bằng AJAX
    $('#editTagForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var tagId = $('#editTagId').val();

        $.ajax({
            type: 'PUT',
            url: '/admin/tags/' + tagId,
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


    $(document).ready(function() {
        // Xử lý sự kiện click vào nút xoá tag
        $('body').on('click', '.delete-cat-btn', function() {
            var tagId = $(this).data('id');

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
                    // Gửi yêu cầu AJAX để xoá tag
                    $.ajax({
                        type: 'DELETE',
                        url: '/admin/tags/' + tagId,
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
});

</script>
@endsection