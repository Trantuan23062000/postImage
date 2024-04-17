<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Photo;
use App\Models\Share;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Admin_controller extends Controller
{
    public function index()
    {
        $totalCount = Photo::count();
        $totalDownloads = Photo::sum('downloads_count');
        $view = Photo::sum('views');
        $share = Share::count();
        $user = User::count();
        $users = User::all();
        $categories = Category::all();
        $photos = Photo::all();
        if (!auth()->check()) {
            // Nếu chưa đăng nhập, chuyển hướng về trang home
            return redirect()->route('admin.login');
        }

        // Kiểm tra quyền của người dùng
        if (auth()->user()->role !== 'admin') {
            // Nếu không có quyền admin, chuyển hướng về trang home
            return redirect()->route('admin.login');
        }

        return view('admin.admin', [
            'totalCount' => $totalCount,
            'totalDownloads' => $totalDownloads,
            'view' => $view,
            'share' => $share,
            'user' => $user,
            'users' => $users,
            'categories' => $categories,
            'photos' => $photos

        ]);
    }

    public function allPost()
    {
        $posts = Photo::orderBy('created_at', 'desc')->paginate(5);
        $totalCount = Photo::count();
        $totalDownloads = Photo::sum('downloads_count');
        $view = Photo::sum('views');
        $share = Share::count();
        $user = User::count();
        return view('admin.content.index',  [
            'totalCount' => $totalCount,
            'totalDownloads' => $totalDownloads,
            'view' => $view,
            'share' => $share,
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function show($id)
    {
        $post = Photo::with('user')->findOrFail($id);
        return response()->json($post);
    }

    public function login()
    {
        return view('admin.login');
    }


    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email không được bỏ trống!',
            'password.required' => 'Password không được bỏ trống!',
            'email.email' => 'Địa chỉ email không hợp lệ!'
        ]);

        $credentials = $request->only('email', 'password');

        // Lấy thông tin người dùng từ email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // Người dùng không tồn tại hoặc mật khẩu không đúng
            return response()->json(['error' => 'Email hoặc mật khẩu không đúng!'], 401);
        }

        // Kiểm tra quyền của người dùng
        if ($user->role !== 'admin') {
            // Nếu không có quyền admin, đăng xuất và trả về lỗi
            return response()->json(['error' => 'Bạn không có quyền truy cập trang admin'], 403);
        }

        // Đăng nhập người dùng
        Auth::login($user);

        // Đăng nhập thành công và có quyền admin
        return response()->json(['success' => 'Đăng nhập thành công!']);
    }


    public function active(Request $request)
    {
        $id = $request->id; // Lấy id từ request
        $post = Photo::findOrFail($id);
        $post->active = $request->active;
        $post->save();

        return response()->json(['success' => 'Bạn đã phê duyệt bài viết']);
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        // Kiểm tra xem người dùng có quyền xóa bài viết không
        if ($photo->user_id != auth()->id() && auth()->user()->role != 'admin') {
            return response()->json(['error' => 'Bạn không có quyền xóa bài viết này.'], 401);
        }

        // Xóa bài viết
        $photo->delete();

        // Trả về phản hồi thành công
        return response()->json(['success' => 'Bài viết đã được xóa thành công!']);
    }

}
