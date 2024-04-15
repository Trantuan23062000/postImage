@extends('home.home')
@section('content')
<main id="main">
  <section id="contact" class="contact mb-5">
    <div class="container" data-aos="fade-up">

      <div class="row">
        <div class="col-lg-12 text-center mb-5">
          <h1 class="page-title">Đăng bài viết</h1>
        </div>
      </div>

      <div class="form mt-5">
        <form id="photoForm" action="{{ route('postImage') }}" method="post" role="form" class="php-email-form">
          @csrf
          <div class="row">
            <div class="form-group col-md-6">
              <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề">
            </div>
            <div class="form-group col-md-6">
              <select class="form-select" name="status">
                <option value="0">Không bản quyền</option>
                <option value="1">Bản quyền</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <select class="form-select" id="category" name="category_id">
                <option selected disabled>Chọn danh mục</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-6">
            <select class="form-select" id="tag_id" name="tag_id">
                <option selected disabled>Chọn thẻ tag</option>
                @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <input type="file" id="imageInput" class="form-control" name="image" placeholder="chọn hình ảnh cần chọn">
          </div>
          <div class="form-group" id="imagePreview">
          </div>
          <div>
          </div>
          <div class="form-group">
            <textarea class="form-control" name="description" rows="5" placeholder="Nhập mô tả"></textarea>
          </div>
          <div class="text-center"><button type="submit">POST</button></div>
        </form>

      </div><!-- End Contact Form -->

    </div>
  </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function() {
    $('#imageInput').on('change', function(e) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var imagePreview = document.getElementById('imagePreview');
        if (imagePreview) { // Kiểm tra xem phần tử 'imagePreview' có tồn tại không
          imagePreview.innerHTML = '<img src="' + e.target.result + '" width="300" />';
        }
      }
      reader.readAsDataURL(this.files[0]);
    });
  });


  $(document).ready(function() {
    $('#photoForm').on('submit', function(e) {
      e.preventDefault();
      var formData = new FormData(this);

      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: response.success
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "{{ route('home') }}"; // Reload trang sau khi đóng alert
            }
          });
        },
        error: function(xhr, status, error) {
          var errors = xhr.responseJSON.errors;
          var errorMessage = '';

          // Loop through errors object and concatenate error messages
          $.each(errors, function(key, value) {
            errorMessage += value + '<br>';
          });

          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: errorMessage // Display concatenated error messages as HTML
          });
        }
      });
    });
  });
</script>

@endsection