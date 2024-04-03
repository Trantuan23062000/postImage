<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Home_controller extends Controller
{
    public function index()
    {
        $photos = Photo::all(); // Lấy tất cả các bài đăng từ cơ sở dữ liệu
        $photos = Photo::with('user')->get();
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
            'email.required' => 'Email không được bỏ trống !',
            'password.required' => 'Password không được bỏ trống !',
            'email.email' => 'Địa chỉ email không hợp lệ !'
        ]);

        $credentials = $request->only('email', 'password');

        // Lấy thông tin người dùng từ email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // Người dùng không tồn tại
            return response()->json(['error' => 'Email hoặc mật khẩu không đúng !']);
        }

        // Kiểm tra mật khẩu
        if (Hash::check($credentials['password'], $user->password)) {
            // Mật khẩu đúng, đăng nhập thành công
            Auth::login($user);
            return response()->json(['success' => 'Đăng nhập thành công !']);
        } else {
            // Mật khẩu không đúng
            return response()->json(['error' => 'Email hoặc mật khẩu không đúng !']);
        }
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

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
        }

        // Tạo token và cập nhật vào cơ sở dữ liệu
        $token = sha1(time() . $user->email);
        DB::table('users')->where('email', $user->email)->update(['token' => $token]);

        // Gửi email chứa liên kết đặt lại mật khẩu
        $resetLink = url('/reset-password/' . $token);
        $this->sendResetEmail($user->email, $resetLink);

        return back()->with('status', 'Đã gửi liên kết đặt lại mật khẩu đến email của bạn.');
       
    }

    private function sendResetEmail($email, $resetLink)
    {
        // Gửi email thông qua Mail facade của Laravel
        Mail::send('linkreset', ['resetLink' => $resetLink], function ($message) use ($email) {
            $message->to($email)->subject('Yêu cầu đặt lại mật khẩu');
        });
    }

    public function showResetForm(Request $request, $token)
    {
        return view('reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset($request->all(), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
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
