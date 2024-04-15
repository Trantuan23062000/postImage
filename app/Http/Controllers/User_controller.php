<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Share;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class User_controller extends Controller
{
    public function index(Request $request)
    {
        // Lấy tất cả người dùng từ cơ sở dữ liệu
        $query = $request->input('query');
        $totalCount = Photo::count();
        $totalDownloads = Photo::sum('downloads_count');
        $view = Photo::sum('views');
        $share = Share::count();
        $users = User::orderBy('created_at', 'desc')->paginate(2);
        $user = User::count();

        // Trả về view hiển thị danh sách người dùng với dữ liệu đã lấy được
        return view('admin.user.index', [
            'totalCount' => $totalCount,
            'totalDownloads' => $totalDownloads,
            'view' => $view,
            'share' => $share,
            'users' => $users,
            'user' => $user,
            'query' => $query
        ]);
    }
    public function showForgotPasswordForm()
    {
        return view('admin.auth.reset');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $email = $request->input('email');

        // Tạo token
        $token = Str::random(60);

        // Lưu token vào trường reset_password_token của người dùng
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update(['password_reset_token' => $token]);
        } else {
            // Xử lý khi không tìm thấy người dùng với email này
            return response()->json(['error' => 'Không tìm thấy người dùng với email này.'], 404);
        }
        // Gửi email xác nhận
        Mail::to($email)->send(new ResetPassword($user, $token));

        return response()->json(['message' => 'Email đã được gửi với hướng dẫn cập nhật mật khẩu.']);
    }


    protected function broker()
    {
        return Password::broker();
    }


    public function formForgot($email, $token)
    {
        // Kiểm tra email và token hợp lệ
        $user = User::where('email', $email)->where('password_reset_token', $token)->first();
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Invalid reset link.');
        }

        return view('admin.auth.reset-password')->with(['email' => $email, 'token' => $token, 'user' => $user]);
    }

    public function reset(Request $request)
    {
        // Kiểm tra xác thực CSRF token
        if (!$request->ajax()) {
            abort(403);
        }

        // Kiểm tra xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        // Tìm người dùng với email và token tương ứng
        $user = User::where('email', $request->email)->where('password_reset_token', $request->token)->first();
        if (!$user) {
            return response()->json(['error' => 'Invalid reset link.'], 400);
        }

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($request->password),
            'password_reset_token' => null
        ]);

        return response()->json(['success' => 'Password reset successfully.']);
    }
}
