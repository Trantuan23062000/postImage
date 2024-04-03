<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class Photo_controller extends Controller
{
    public function index()
    {
        return view('Posts.postImage');
    }

    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'image.required' => 'Vui lòng chọn một hình ảnh.',
            'image.image' => 'Tệp phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg hoặc gif.',
            'image.max' => 'Kích thước hình ảnh tối đa là 2MB.',
        ]);

        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để thực hiện thao tác này.'], 401);
        }

        // Create new Photo instance
        $photo = new Photo();
        $photo->user_id = auth()->id();
        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->status = $request->status ?? 0; // Default status is 0 if not provided

        // Process and store image
        $imagePath = $request->file('image')->store('images');
        $photo->image_url = $imagePath;

        // Save photo to database
        $photo->save();

        // Return success response
        return response()->json(['success' => 'Hình ảnh đã được tải lên thành công!']);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($id)
    {
        // Lấy thông tin của hình ảnh cần chỉnh sửa
        $photo = Photo::findOrFail($id);

        // Kiểm tra xem người dùng có quyền chỉnh sửa không (ví dụ: chỉ cho phép chỉnh sửa hình ảnh của chính họ)
        if ($photo->user_id != auth()->id()) {
            // Nếu không có quyền, chuyển hướng về trang trước đó hoặc trang khác có thể xác định
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa hình ảnh này.');
        }

        // Trả về view để hiển thị form chỉnh sửa với dữ liệu của hình ảnh
        return view('Posts.edit', compact('photo'));
    }
    public function update(Request $request, $id)
    {
        // Validate form data
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'image.image' => 'Tệp phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg hoặc gif.',
            'image.max' => 'Kích thước hình ảnh tối đa là 2MB.',
        ]);

        // Lấy thông tin của hình ảnh cần chỉnh sửa
        $photo = Photo::findOrFail($id);

        // Kiểm tra xem người dùng có quyền chỉnh sửa không (ví dụ: chỉ cho phép chỉnh sửa hình ảnh của chính họ)
        if ($photo->user_id != auth()->id()) {
            // Nếu không có quyền, trả về response lỗi
            return response()->json(['error' => 'Bạn không có quyền chỉnh sửa hình ảnh này.'], 401);
        }

        // Cập nhật thông tin của hình ảnh
        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->status = $request->status ?? 0;

        // Nếu có tệp hình ảnh mới được tải lên, xử lý và lưu hình ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images');
            $photo->image_url = $imagePath;
        }

        // Lưu thay đổi vào cơ sở dữ liệu
        $photo->save();

        // Trả về response thành công
        return response()->json(['success' => 'Hình ảnh đã được cập nhật thành công!']);
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        // Kiểm tra xem người dùng có quyền xóa bài viết không
        if ($photo->user_id != auth()->id()) {
            return response()->json(['error' => 'Bạn không có quyền xóa bài viết này.'], 401);
        }

        // Xóa bài viết
        $photo->delete();

        // Trả về phản hồi thành công
        return response()->json(['success' => 'Bài viết đã được xóa thành công!']);
    }
}
