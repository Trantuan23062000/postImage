@extends('home')
@section('mypost')
<section>
  <div class="container" data-aos="fade-up">
    <div class="row">
      <div class="col-lg-12 text-center mb-5">
        <h1 class="page-title">Bài viết đã đăng</h1>
      </div>
    </div>

    @if ($userPhotos->isEmpty())
    <p>Chưa có hình ảnh nào.</p>
    @else

    <div class="row mb-5">
      @foreach ($userPhotos as $photo )
      <div class="d-md-flex post-entry-2 half">
        <div class="me-4 thumbnail">
         <a href="{{ route('viewPost', ['id' => $photo->id]) }}"> <img src="/storage/{{ $photo->image_url }}" alt="{{ $photo->title }}" class="img-fluid custom-image"></a>
        </div>
        <div class="ps-md-5 mt-4 mt-md-0">
          <div class="post-meta mt-4">@if ($photo->status == 1)
            <span>Hình ảnh có bản quyền</span>
            @else
            <span>Hình ảnh không có bản quyền</span>
            @endif
          </div>
          <h2 class="mb-4 display-4">{{ $photo->title}}</h2>
          <p>{{$photo->description}}</p>
          <p>Fugit eaque illum blanditiis, quo exercitationem maiores autem laudantium unde excepturi dolores quasi eos vero harum ipsa quam laborum illo aut facere voluptates aliquam adipisci sapiente beatae ullam. Tempora culpa iusto illum accusantium cum hic quisquam dolor placeat officiis eligendi.</p>
          <a href="{{ route('postEdit', ['id' => $photo->id]) }}"><i class="bi bi-pencil-square"></i></a>
          <a href="{{ route('viewPost', ['id' => $photo->id]) }}"><i class="bi bi-broadcast"></i></a>
          <a class="delete-post-btn" data-id="{{ $photo->id }}"><i class="bi bi-trash-fill"></i></a>
        </div>
      </div>
      @endforeach

    </div>
    @endif

  </div>
  <style>
    .custom-image {
      max-width: 720px;
      /* Đặt kích thước tối đa cho chiều rộng */
      max-height: 720px;
      /* Đặt kích thước tối đa cho chiều cao */
      width: auto;
      /* Đảm bảo chiều rộng tự động điều chỉnh */
      height: auto;
      /* Đảm bảo chiều cao tự động điều chỉnh */
    }
  </style>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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

@endsection