@extends('admin.admin')
@section('content')
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Loại</th>
            <th scope="col">Thẻ</th>
            <th scope="col">Người đăng</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <th scope="row">{{ $loop->index + 1 }}</th>
            <td> {{ Str::limit($post->title, 10) }}</td>
            <td>{{$post->category->name}}</td>
            <td>{{$post->tag->name}}</td>
            <td>{{$post->user->username}}</td>
            <td>
                <img src="{{ asset($post->img_url) }}" alt="Ảnh bài viết" width="100">
            </td>
            <td><a class="edit-cat-btn"><i class="bi bi-box-arrow-up-right"></i></a><a class="delete-cat-btn"><i class="bi bi-trash-fill"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection