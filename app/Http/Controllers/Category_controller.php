<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Photo;
use App\Models\Share;
use App\Models\User;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;

class Category_controller extends Controller
{
    public function index()
    {
        $totalCount = Photo::count();
        $totalDownloads = Photo::sum('downloads_count');
        $view = Photo::sum('views');
        $share = Share::count();
        $user = User::count();
        $category = Category::latest()->get(); // Sắp xếp từ mới nhất đến cũ nhất
        return view('admin.category.index',  [
            'totalCount' => $totalCount,
            'totalDownloads' => $totalDownloads,
            'view' => $view,
            'share'=>$share,
            'user'=>$user,
            'category'=>$category
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validate dữ liệu
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:tags,name'
            ], [
                'name.required' => 'Loại bài viết không được bỏ trống !',
                'name.unique' => 'Loại bài viết này đã tồn tại !',
                'name.string' => 'Loại bài viết này không được nhập số !',
                'name.max' => 'Loại bài viết này không quá 255 kí tự !'
            ]);

            // Tạo mới Tag
            $category = new Category();
            $category->name = $request->name;
            $category->save();

            return response()->json(['message' => 'Loại bài viết đã được thêm mới thành công.']);
        } catch (ValidationException $e) {
            // Lấy danh sách lỗi từ exception
            $errors = $e->validator->getMessageBag()->toArray();

            // Trả về lỗi validation dưới dạng JSON
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:tags,name,' . $id
            ], [
                'name.required' => 'Tên loại không được bỏ trống!',
                'name.string' => 'Dùng chuỗi không được dùng kí tự!',
                'name.max' => 'Không vượt quá 255 kí tự!'
            ]);

            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();

            return response()->json(['success' => 'Loại đã được cập nhật thành công.']);
        } catch (ValidationException $e) {
            // Lấy danh sách lỗi từ exception
            $errors = $e->validator->getMessageBag()->toArray();

            // Trả về lỗi validation dưới dạng JSON
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['success' => 'Loại bài viết đã được xoá thành công.']);
        } catch (\Exception $e) {
            // Xử lý lỗi và hiển thị thông báo lỗi
            return response()->json(['error' => 'Đã xảy ra lỗi khi xoá loại bài viết.'], 500);
        }
    }
}
