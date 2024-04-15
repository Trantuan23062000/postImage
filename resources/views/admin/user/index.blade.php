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
                <a class="view-post-btn"><i class="bi bi-box-arrow-up-right"></i></a>
                <a class="delete-post-btn"><i class="bi bi-trash-fill"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
{{ $users->appends(['query' => $query])->links() }}
</div>
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
</script>
@endsection