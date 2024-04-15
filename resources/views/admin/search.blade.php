@extends('admin.admin')
@section('content')

<table class="table table-bordered">
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
@endsection