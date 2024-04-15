<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Download;
use Illuminate\Support\Facades\Storage;



class Home_controller extends Controller
{
    public function index()
    {
        //$photos = Photo::with('user')->get();
        $photos = Photo::orderBy('created_at', 'desc')->paginate(3);
        $cat = Category::all();
        $tag= Tag::all();
        return view('home.index', compact('photos','cat','tag'));
    }

    public function register()
    {
        return view('home.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'

        ], [
            'email.required' => 'Email không được bỏ trống.',
            'username.required' => 'Username không được bỏ trống !',
            'password.required' => 'Password không được bỏ trống !',
            'password.min' => 'Password không được dưới 6 kí tự !',
            'password.confirmed' => 'Xác nhận mật khẩu khôg đúng ',
            'email.email' => 'Email không đúng định dạng !'
        ]);

        $passwordHash = Hash::make($request->password);

        // Tạo người dùng mới
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = $passwordHash;

        $user->save();
        return response()->json(['success' => 'Registration successful. Please log in.']);
    }

    public function login()
    {
        return view('home.login');
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

        // Đăng nhập người dùng
        Auth::login($user);

        return response()->json(['success' => 'Đăng nhập thành công!']);
    }

    public function logout()
    {
        Auth::logout(); // Đăng xuất người dùng
        return redirect()->route('home'); // Chuyển hướng về trang chủ sau khi đăng xuất
    }

    public function forgot()
    {
        return view('forgot');
    }


    public function checkLogin(Request $request)
    {
        if ($request->user()) {
            // Người dùng đã đăng nhập
            return response()->json(['message' => 'Authenticated']);
        } else {
            // Người dùng chưa đăng nhập
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $photos = Photo::where('title', 'like', "%$keyword%")
                      ->orWhere('description', 'like', "%$keyword%")
                      ->paginate(10); // Số lượng bài viết trên mỗi trang

        return view('home.search', compact('photos', 'keyword'));
    }
   
    public function downloadPhoto($id)
    {
        $photo = Photo::findOrFail($id);

        // Kiểm tra xem hình ảnh có status là 0 hay không
        if ($photo->status == 0) {
            // Tăng số lượt tải của hình ảnh
            $photo->downloads_count++;
            $photo->save();

            // Tạo một bản ghi mới trong bảng downloads
            Download::create(['photo_id' => $photo->id]);

            // Tải hình ảnh xuống máy
            return Storage::download($photo->image_url);
        } else {
            return response()->json(['error' => 'Bạn không thể tải hình ảnh này.'], 403);
        }
    }

    public function filter(Request $request)
    {
        // Lấy tham số từ URL
        $categoryId = $request->input('cat');
        $tagId = $request->input('tag');

        // Truy vấn cơ sở dữ liệu để lấy bài viết phù hợp dựa trên các tham số
        if ($categoryId) {
            $photos = Photo::where('category_id', $categoryId)->get();
        } elseif ($tagId) {
            $photos = Photo::whereHas('tag', function ($query) use ($tagId) {
                $query->where('id', $tagId);
            })->get();
        } else {
            $photos = Photo::all();
        }

        // Trả về view với danh sách bài viết đã lọc
        return view('home.filtered_posts', ['photos' => $photos]);
    }
}
