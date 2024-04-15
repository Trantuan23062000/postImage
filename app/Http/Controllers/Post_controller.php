<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\Request;

class Post_controller extends Controller
{
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!auth()->check()) {
            // Nếu chưa đăng nhập, chuyển hướng về trang home
            return redirect()->route('home');
        }

        // Lấy danh sách bài viết của người dùng hiện tại
        $userPhotos = Photo::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(2);

        return view('home.Posts.mypost', compact('userPhotos'));
    }


    public function show($id)
    {
        $post = Photo::findOrFail($id);
        $comments = Comment::where('photo_id', $id)->get();
        $commentCount = $comments->count(); // Đếm số lượng comment
        return view('home.Posts.show', compact('post', 'comments', 'commentCount'));
    }

    public function views($id)
    {
        // Tìm bài viết theo ID
        $photo = Photo::find($id);

        // Kiểm tra xem bài viết có tồn tại không
        if (!$photo) {
            return response()->json(['error' => 'Không tìm thấy bài viết có id ' . $id . '.'], 404);
        }

        // Tăng số lượt xem của bài viết lên 1
        $photo->views += 1;

        // Lưu thay đổi vào cơ sở dữ liệu
        $photo->save();

        // Trả về một phản hồi chuyển hướng đến trang chi tiết của bài viết
        return redirect()->route('viewPost', ['id' => $photo->id]);
    }
}
