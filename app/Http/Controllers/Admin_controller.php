<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class Admin_controller extends Controller
{
    public function index()
    {
        return view('admin.admin');
    }

    public function allPost()
    {
        $posts = Photo::all();
        return view('admin.content.index', compact('posts'));
    }
}
