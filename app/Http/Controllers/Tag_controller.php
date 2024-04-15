<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Share;
use Illuminate\Validation\ValidationException;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class Tag_controller extends Controller
{
    public function index()
    {
        $totalCount = Photo::count();
        $totalDownloads = Photo::sum('downloads_count');
        $view = Photo::sum('views');
        $share = Share::count();
        $user = User::count();
        $tags = Tag::latest()->get(); // Sắp xếp từ mới nhất đến cũ nhất
        return view('admin.tag.index',  [
            'totalCount' => $totalCount,
            'totalDownloads' => $totalDownloads,
            'view' => $view,
            'share'=>$share,
            'user'=>$user,
            'tags'=>$tags
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validate dữ liệu
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:tags,name'
            ], [
                'name.required' => 'Thẻ tag không được bỏ trống !',
                'name.unique' => 'Thẻ tag này đã tồn tại !',
                'name.string' => 'Thẻ tag này không được nhập số !',
                'name.max' => 'Thẻ tag này không quá 255 kí tự !'
            ]);

            // Tạo mới Tag
            $tag = new Tag();
            $tag->name = $request->name;
            $tag->save();

            return response()->json(['message' => 'Tag đã được thêm mới thành công.']);
        } catch (ValidationException $e) {
            // Lấy danh sách lỗi từ exception
            $errors = $e->validator->getMessageBag()->toArray();

            // Trả về lỗi validation dưới dạng JSON
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return response()->json($tag);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:tags,name,' . $id
            ], [
                'name.required' => 'Tên tag không được bỏ trống!',
                'name.string' => 'Dùng chuỗi không được dùng kí tự!',
                'name.max' => 'Không vượt quá 255 kí tự!'
            ]);

            $tag = Tag::findOrFail($id);
            $tag->name = $request->name;
            $tag->save();
            
            return response()->json(['success' => 'Tag đã được cập nhật thành công.']);
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
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return response()->json(['success' => 'Tag đã được xoá thành công.']);
        } catch (\Exception $e) {
            // Xử lý lỗi và hiển thị thông báo lỗi
            return response()->json(['error' => 'Đã xảy ra lỗi khi xoá Tag.'], 500);
        }
    }
}
