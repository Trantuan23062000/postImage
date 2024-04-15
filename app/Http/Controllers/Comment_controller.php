<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Comment_controller extends Controller
{
    public function store(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để thực hiện hành động này.'], 401);
        }

        $request->validate([
            'photo_id' => 'required|exists:photos,id',
            'content' => 'required|string',
        ], [
            'content.required' => 'Commnent không được bỏ trống !',
            'photo_id.exists' => 'Hình ảnh đã không tồn tại !',
            'photo_id.required' => 'Hình ảnh không có !'
        ]);

        // Lưu comment vào cơ sở dữ liệu
        Comment::create([
            'photo_id' => $request->photo_id,
            'user_id' => auth()->user()->id,
            'content' => $request->content,
        ]);

        return response()->json(['success' => 'Comment đã được gửi thành công.']);
    }

    public function update(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'content' => 'required|string',
        ]);

        try {
            // Tìm bình luận cần chỉnh sửa trong cơ sở dữ liệu
            $comment = Comment::findOrFail($id);

            // Kiểm tra xem người dùng có quyền chỉnh sửa bình luận hay không
            // Ở đây, chúng ta kiểm tra xem người dùng có phải là chủ sở hữu của bình luận hay không
            if ($comment->user_id !== auth()->id()) {
                return response()->json(['error' => 'Bạn không có quyền chỉnh sửa bình luận này.'], 403);
            }

            // Cập nhật nội dung của bình luận
            $comment->update([
                'content' => $request->content,
            ]);

            // Trả về thông báo thành công
            return response()->json(['success' => 'Bình luận đã được chỉnh sửa thành công.']);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ nếu có lỗi xảy ra
            return response()->json(['error' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau.'], 500);
        }
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
    
        // Kiểm tra xem người đăng nhập có phải là người tạo ra bình luận hoặc là admin không
        if (auth()->user()->id == $comment->user_id || auth()->user()->role == 'admin') {
            // Nếu là người đăng bài hoặc là admin, cho phép xoá bình luận
            $comment->delete();
            return response()->json(['success' => 'Bình luận đã được xóa thành công.']);
        } else {
            // Nếu không phải là người đăng bài hoặc admin, trả về lỗi
            return response()->json(['error' => 'Bạn không có quyền thực hiện thao tác này.'], 403);
        }
    }
    
}
