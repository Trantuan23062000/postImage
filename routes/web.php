<?php

use App\Http\Controllers\Admin_controller;
use App\Http\Controllers\Home_controller;
use App\Http\Controllers\Photo_controller;
use App\Http\Controllers\Post_controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


Route::get('/', [Home_controller::class,'index'])->name('home');
Route::get('/register',[Home_controller::class,'register'])->name('home.register');
Route::post('/postRegister',[Home_controller::class,'postRegister'])->name('postRegister');
Route::get('/login',[Home_controller::class,'login'])->name('login');
Route::post('/postLogin',[Home_controller::class,'postLogin'])->name('postLogin');
Route::post('/logout', [Home_controller::class,'logout'])->name('logout');
Route::get('/forgot',[Home_controller::class,'forgot'])->name('forgot');
Route::post('/sendLink',[Home_controller::class,'sendResetLinkEmail'])->name('send');
Route::get('/reset/{token}',[Home_controller::class,'showResetForm'])->name('showreset');
Route::post('/reset-password',[Home_controller::class,'reset'])->name('formReset');
Route::get('/my-post',[Post_controller::class,'index'])->name('myPost');
Route::get('/post',[Photo_controller::class,'index'])->name('post');
Route::post('/postImage',[Photo_controller::class,'store'])->name('postImage');
Route::get('/search', [Photo_controller::class, 'search'])->name('search');
Route::get('/allPost', [Home_controller::class,'index'])->name('allPost');
Route::get('/viewPost/{id}', [Post_controller::class,'show'])->name('viewPost');



Route::middleware(['auth'])->group(function(){
Route::get('/EditPost/{id}', [Photo_controller::class, 'edit']) ->name('postEdit');
Route::put('/updatePost/{id}',[Photo_controller::class,'update'])->name('updatePost');
Route::delete('/deletePost/{id}', [Photo_controller::class, 'destroy'])->name('deletePost');

});



Route::get('/storage/{path}', function ($path) {
    $path = storage_path('app/' . $path);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->where('path', '.*');



Route::get('/check-login', function () {
    if (auth()->check()) {
        return response()->json(['status' => 'logged_in']);
    } else {
        return response()->json(['status' => 'logged_out']);
    }
});





Route::get('/admin',[Admin_controller::class,'index'])->name('admin');