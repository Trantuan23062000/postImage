@extends('home')
@section('content')
<section class="single-post-content">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="container">
    <!-- Modal -->
    <div class="modal fade" id="updateCommentModal" tabindex="-1" aria-labelledby="updateCommentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="updateCommentForm">
            <div class="modal-header">
              <h5 class="modal-title" id="updateCommentModalLabel">Cập Nhật Bình Luận</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="updateContent" class="form-label">Nội dung bình luận</label>
                <textarea class="form-control" id="updateContent" name="content" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
              <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-9 post-content" data-aos="fade-up">

        <!-- ======= Single Post Content ======= -->
        <div class="single-post">
          <div class="post-meta"><span class="date">{{$post->category->name}}</span> <span class="mx-1">&bullet;</span> <span>{{$post->created_at}}</span></div>
          <h1 class="mb-5">{{$post->title}}</h1>
          <figure class="my-4">
            <img src="/storage/{{ $post->image_url }}" alt="" class="img-fluid post-image">
            <figcaption>
              <span style="font-size: 18px;">{{$post->description}}</span>
            </figcaption>
          </figure>
        </div><!-- End Single Post Content -->

        <!-- ======= Comments ======= -->
        <div class="comments">
          <div class="comment d-flex mb-4">
            <div class="flex-grow-1 ms-2 ms-sm-3">
              <div class="comment-replies bg-light p-3 mt-3 rounded">
                <h6 class="comment-replies-title mb-4 text-muted text-uppercase">{{$commentCount}} Bình luận</h6>
                @foreach($comments as $comment)
                <div class="reply d-flex mb-4">
                  <div class="flex-shrink-0">
                    <div class="avatar avatar-sm rounded-circle">
                      <img class="avatar-img" src="/home/assets/img/favicon.png" alt="" class="img-fluid">
                    </div>
                  </div>

                  <div class="flex-grow-1 ms-2 ms-sm-3">
                    <div class="reply-meta d-flex align-items-baseline">
                      <h6 class="mb-0 me-2">{{ $comment->user->username }}</h6>
                      <span class="text-muted">{{$comment->created_at}}</span>
                    </div>
                    <div class="reply-body">
                      {{ $comment->content }}
                      @if($comment->user_id == auth()->id())
                      <a href="javascript:void(0)" class="edit-comment" data-id="{{ $comment->id }}" data-content="{{ $comment->content }}"><i class="bi bi-pencil"></i></a>
                      <a href="javascript:void(0)" class="delete-comment" data-id="{{ $comment->id }}"><i class="bi bi-trash"></i></a>
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div><!-- End Comments -->

        <!-- ======= Comments Form ======= -->
        <div class="row justify-content-center mt-5">

          <div class="col-lg-12">
            <h5 class="comment-title">Bình luận ảnh</h5>
            <div class="row">
              <div class="col-12 mb-3">
                <textarea id="commentContent" class="form-control" name="content" cols="30" rows="10"></textarea>
                <input type="hidden" id="isLoggedIn" value="{{ auth()->check() ? 'true' : 'false' }}">
                <input type="hidden" id="photoId" value="{{ $post->id }}">
              </div>
              <div class="col-12">
                <button id="submitComment" type="submit" class="btn btn-primary text-uppercase">Bình luận</button>
              </div>
            </div>
          </div>
        </div><!-- End Comments Form -->

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
            <li><i class="bi bi-chevron-right"></i> {{$post->category->name}}</li>

          </ul>
        </div><!-- End Categories -->

        <div class="aside-block">
          <h3 class="aside-title">Tags</h3>
          <ul class="aside-tags list-unstyled">
            <li><a>{{$post->tag->name}}</a></li>
          </ul>
        </div><!-- End Tags -->

      </div>
    </div>
  </div>
</section>
<style>
  .post-image {
    max-width: 200%;
    max-height: 600px;
    /* Thay đổi giá trị này tùy thuộc vào kích thước bạn muốn giới hạn */
  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    // Lắng nghe sự kiện click trên nút "Bình luận"
    $('#submitComment').click(function() {
      // Kiểm tra đăng nhập
      if (!checkLoggedIn()) {
        // Nếu chưa đăng nhập, hiển thị thông báo yêu cầu đăng nhập
        showLoginAlert();
        return;
      }
      // Lấy dữ liệu bình luận và mã token CSRF
      var content = $('#commentContent').val();
      var photoId = $('#photoId').val();
      var userId = $('#userId').val();
      var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Lấy mã token CSRF từ thẻ meta

      // Gửi dữ liệu bình luận đến server bằng AJAX
      $.ajax({
        type: 'POST',
        url: '/comment/store',
        headers: {
          'X-CSRF-TOKEN': csrfToken // Bao gồm mã token CSRF trong header của yêu cầu
        },
        data: {
          photo_id: photoId,
          user_id: userId,
          content: content
        },
        success: function(response) {
          // Hiển thị thông báo thành công
          Swal.fire({
            icon: 'success',
            text: response.success,
          }).then((result) => {
            // Sau khi người dùng nhấn OK, reload trang
            if (result.isConfirmed) {
              location.reload(); // Reload trang
            }
          });;
          // Xóa nội dung của textarea sau khi gửi thành công
          $('#commentContent').val('');
        },
        error: function(xhr, status, error) {
          // Nếu có lỗi, trích xuất thông báo lỗi từ phản hồi và hiển thị nó
          var err = JSON.parse(xhr.responseText);
          var errMsg = err.errors.content[0];
          Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: errMsg
          });
        }
      });
    });
  });

  // Hàm kiểm tra đăng nhập
  function checkLoggedIn() {
    // Lấy giá trị đăng nhập từ trường ẩn
    var isLoggedIn = $('#isLoggedIn').val() === 'true';
    return isLoggedIn;
  }

  // Hàm hiển thị thông báo yêu cầu đăng nhập
  function showLoginAlert() {
    sessionStorage.setItem('returnUrl', window.location.href);
    Swal.fire({
      icon: 'info',
      title: 'Vui lòng đăng nhập',
      text: 'Bạn cần đăng nhập để gửi comment.',
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

  $(document).ready(function() {
    // Mở modal và điền nội dung bình luận cần cập nhật
    $(document).on('click', '.edit-comment', function() {
      var commentId = $(this).data('id');
      var commentContent = $(this).data('content');
      $('#updateContent').val(commentContent);
      $('#updateCommentModal').modal('show');

      // Submit form cập nhật bình luận
      $('#updateCommentForm').submit(function(e) {
        e.preventDefault();
        var updatedContent = $('#updateContent').val();
        $.ajax({
          type: 'PUT',
          url: '/comment/update/' + commentId,
          beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
          },
          data: {
            content: updatedContent
          },
          success: function(response) {
            // Hiển thị thông báo thành công
            Swal.fire({
              icon: 'success',
              text: response.success,
            }).then((result) => {
              // Sau khi người dùng nhấn OK, reload trang
              if (result.isConfirmed) {
                location.reload();
              }
            });
          },
          error: function(xhr, status, error) {
            // Hiển thị thông báo lỗi
            Swal.fire({
              icon: 'error',
              title: 'Lỗi',
              text: 'Có lỗi xảy ra. Vui lòng thử lại sau.',
            });
          }
        });
      });
    });
  });

  $(document).ready(function() {
    // Xóa bình luận
    $(document).on('click', '.delete-comment', function() {
      var commentId = $(this).data('id');
      Swal.fire({
        title: 'Bạn có chắc muốn xóa bình luận này?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'DELETE',
            url: '/comment/delete/' + commentId,
            beforeSend: function(xhr) {
              xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(response) {
              // Xử lý khi xóa thành công
              Swal.fire({
                icon: 'success',
                text: response.success,
              }).then((result) => {
                // Sau khi người dùng nhấn OK, reload trang
                if (result.isConfirmed) {
                  location.reload();
                }
              });
            },
            error: function(xhr, status, error) {
              // Xử lý khi có lỗi
              Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Có lỗi xảy ra. Vui lòng thử lại sau.',
              });
            }
          });
        }
      });
    });
  });
</script>

@endsection