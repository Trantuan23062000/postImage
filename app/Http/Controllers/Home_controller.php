<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class Home_controller extends Controller
{
    public function index()
    {
        //$photos = Photo::with('user')->get();
        $photos = Photo::orderBy('created_at', 'desc')->paginate(2);
        return view('home.index', compact('photos'));
       
    }
    
    public function register()
    {
        return view('register');
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
        $user->password = $passwordHash;

        $user->save();
        return response()->json(['success' => 'Registration successful. Please log in.']);
    }

    public function login()
    {
        return view('login');
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
}
