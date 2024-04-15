  @extends('home.home')
  @section('content')
  <main id="main">
    <section id="contact" class="contact mb-5">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 text-center mb-5">
            <h1 class="page-title">Chỉnh sửa bài đăng</h1>
          </div>
        </div>

        <div class="form mt-5">
          <form id="editPostForm" data-id="{{ $photo->id }}" class="php-email-form" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <input type="text" name="title" class="form-control" value="{{$photo->title}}" placeholder="Nhập tiêu đề">
              </div>
              <div class="form-group col-md-6">
                <select class="form-select" name="status">
                  <option value="0" {{ $photo->status == 0 ? 'selected' : '' }}>Không bản quyền</option>
                  <option value="1" {{ $photo->status == 1 ? 'selected' : '' }}>Có bản quyền</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <select class="form-select" id="category" name="category_id">
                  <option selected disabled>Chọn danh mục</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ $category->id == $photo->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
              <select class="form-select" id="tag_id" name="tag_id">
                  <option selected disabled>Chọn thẻ tag</option>
                  @foreach($tags as $tag)
                  <option value="{{ $tag->id }}" {{ $tag->id == $photo->tag_id ? 'selected' : '' }}>{{ $tag->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <input type="file" id="imageInput" name="image" accept="image/*" onchange="previewImage(this)">
            </div>
            <img id="imagePreview" src="{{ asset('/storage/' . $photo->image_url) }}" alt="Current Image" width="300">

            <div class="form-group" id="imagePreview">

            </div>
            <div>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="description" rows="5" placeholder="Nhập mô tả">{{$photo->description}}</textarea>
            </div>
            <div class="text-center"><button type="submit" id="updatePostBtn">Lưu thay đổi</button></div>
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
      $('#editPostForm').submit(function(e) {
        e.preventDefault();
        var postId = $(this).data('id');
        var formData = new FormData(this);
        formData.append('_method', 'PUT'); // Thêm phương thức PUT vào dữ liệu form

        $.ajax({
          url: '/updatePost/' + postId,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Thành công!',
              text: response.success
            }).then(function() {
              var previousPage = document.referrer; // Lấy đường dẫn của trang trước đó
              window.location.href = previousPage; // Chuyển hướng về trang trước đó sau khi đóng thông báo
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
              title: 'Lỗi...',
              html: errorMessage // Display concatenated error messages as HTML
            });
          }
        });
      });
    });

    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#imagePreview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

  </script>

  @endsection