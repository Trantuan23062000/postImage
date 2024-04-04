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
        $userPhotos = Photo::where('user_id', auth()->id())->get();
        $userPhotos = Photo::orderBy('created_at', 'desc')->paginate(2);
        return view('Posts.mypost', compact('userPhotos'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $userPhotos = Photo::where('title', 'like', "%$search%");
        return response()->json($userPhotos);
    }

    public function show($id){
        $post = Photo::findOrFail($id);
        $comments = Comment::where('photo_id', $id)->get();
        $commentCount = $comments->count(); // Đếm số lượng comment
        return view('Posts.show',compact('post','comments','commentCount'));
    }

    
}
