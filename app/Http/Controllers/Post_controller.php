<?php

namespace App\Http\Controllers;

use App\Models\Photo;

use Illuminate\Http\Request;

class Post_controller extends Controller
{
    public function index()
    {
        $userPhotos = Photo::where('user_id', auth()->id())->get();
        //$photos = Photo::paginate(1);
        return view('Posts.mypost', compact('userPhotos'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $userPhotos = Photo::where('title', 'like', "%$search%");
        return response()->json($userPhotos);
    }

    public function show($id){
        $post = Photo::findOrFail($id);
        return view('Posts.show', ['post' => $post]);
    }

    
}
