<?php

namespace App\Http\Middleware;

use App\Models\Photo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPhotoOwner
{
    public function handle($request, Closure $next)
    {
        $photoId = $request->route('id');
        $photo = Photo::find($photoId);

        if (!$photo || $photo->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa hình ảnh này.');
        }

        return $next($request);
    }
}
