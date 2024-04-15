@extends('home.home')
@section('content')
<section>
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
            @php
            $count = 0;
            @endphp
            @foreach ($photos as $photo)
            @if($photo->active !== null)
            @php
            $count++;
            @endphp
            <div class="d-md-flex post-entry-2 half">
                <a href="{{ route('viewPost', ['id' => $photo->id]) }}" class="me-4 thumbnail view-photo" data-photo-id="{{ $photo->id }}">
                    <img src="{{ asset('/storage/' . $photo->image_url) }}" alt="" class="img-fluid @if($photo->status == 1) copyrighted @endif">
                </a>
                <div>
                    <div class="post-meta"><span class="date">Culture</span> <span class="mx-1">&bullet;</span> <span>{{$photo->created_at}}</span></div>
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
                        <li><a>View:{{$photo->views}}</a></li>
                        <li><a>Lượt tải:{{$photo->downloads_count}}</a></li>
                    </ul>
                    </ul>
                    <div class="post-meta mt-4">
                        <div>
                            <a href="{{ route('viewPost', ['id' => $photo->id]) }}" data-photo-id="{{ $photo->id }}" class="btn btn-primary view-photo">
                                <span>Xem bài viết</span>
                                @if ($photo->status == 1)
                                <span><i class="bi bi-eye-slash-fill"></i>{{$photo->views}}</span>
                                @else
                                <span><i class="bi bi-eye-fill"></i></span>
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
                    @if ($photo->status == 0 || auth()->user()->id == $photo->user_id )
                    <div class="btn-group" role="group">
                        @if(auth()->check())
                        <a href="{{ asset('/storage/' . $photo->image_url) }}" download="image.jpg" id="downloadBtn" class="btn btn-primary" data-photo-id="{{ $photo->id }}><i class="bi bi-download"></i> Download</a>
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

            </div>
            @endif
            
            @endforeach

        </div>
        @if($count == 0)
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="alert d-flex align-items-center justify-content-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <div>
                        Không có kết quả bạn cần tìm kiếm
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('home') }}" class="btn btn-dark mt-3">Trở về trang chủ</a>
                </div>
            </div>
        </div>
        @endif
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

        .text-center {
            text-align: center;
            margin-top: 50px;
            /* Khoảng cách từ đỉnh màn hình */
        }
    </style>
</section>
@endsection