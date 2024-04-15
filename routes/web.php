<?php

use App\Http\Controllers\Admin_controller;
use App\Http\Controllers\Auth_Controller;
use App\Http\Controllers\Comment_controller;
use App\Http\Controllers\Home_controller;
use App\Http\Controllers\Photo_controller;
use App\Http\Controllers\Post_controller;
use App\Http\Controllers\Tag_controller;
use App\Http\Controllers\Category_Controller;
use App\Http\Controllers\User_controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


Route::get('/', [Home_controller::class, 'index'])->name('home');
Route::get('/register', [Home_controller::class, 'register'])->name('home.register');
Route::post('/postRegister', [Home_controller::class, 'postRegister'])->name('postRegister');
Route::get('/login', [Home_controller::class, 'login'])->name('login');
Route::post('/postLogin', [Home_controller::class, 'postLogin'])->name('postLogin');
Route::post('/logout', [Home_controller::class, 'logout'])->name('logout');
Route::get('/forgot', [Home_controller::class, 'forgot'])->name('forgot');
Route::get('/post', [Photo_controller::class, 'index'])->name('post');
Route::post('/postImage', [Photo_controller::class, 'store'])->name('postImage');
Route::get('/allPost', [Home_controller::class, 'index'])->name('allPost');
Route::get('/viewPost/{id}', [Post_controller::class, 'show'])->name('viewPost');
Route::post('/comment/store', [Comment_controller::class, 'store']);
Route::put('/comment/update/{id}', [Comment_controller::class, 'update']);
Route::delete('/comment/delete/{id}', [Comment_controller::class, 'delete']);
Route::get('/my-post', [Post_controller::class, 'index'])->name('myPost');
Route::post('/search', [Home_controller::class, 'search'])->name('search');
Route::get('/download/{id}', [Home_controller::class, 'downloadPhoto'])->name('photo.download');
Route::get('/filter/posts', [Home_controller::class, 'filter'])->name('filter.posts');

Route::get('/photos/{id}/views', [Post_controller::class, 'views'])->name('photo.views');

// Route cho trang chia sẻ bài viết
Route::post('/photos/{id}/share', [Photo_Controller::class, 'share'])->name('sharePost');


Route::delete('/admin/deletePost/{id}', [Admin_controller::class, 'destroy'])->name('admin.deletePost');
Route::get('/admin/user', [User_controller::class, 'index'])->name('admin.user');




Route::middleware(['auth'])->group(function () {
    Route::get('/EditPost/{id}', [Photo_controller::class, 'edit'])->name('postEdit');
    Route::put('/updatePost/{id}', [Photo_controller::class, 'update'])->name('updatePost');
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



Route::get('/admin', [Admin_controller::class, 'index'])->name('admin');
Route::get('/admin/post', [Admin_controller::class, 'allPost'])->name('admin.post');
Route::get('/admin/post/{id}', [Admin_controller::class, 'show'])->name('admin.show');

Route::get('/admin/login', [Admin_controller::class, 'login'])->name('admin.login');
Route::post('/admin/postLogin', [Admin_controller::class, 'postLogin'])->name('admin.postLogin');
Route::post('/admin/active', [Admin_controller::class, 'active'])->name('admin.active');



Route::get('/admin/tags', [Tag_controller::class, 'index'])->name('admin.tag');
Route::post('/admin/addTag', [Tag_Controller::class, 'store']);
Route::get('/admin/tags/{id}/edit', [Tag_Controller::class, 'edit'])->name('admin.tags.edit');
Route::put('/admin/tags/{id}', [Tag_controller::class, 'update']);
Route::delete('/admin/tags/{id}', [Tag_Controller::class, 'destroy']);


Route::get('/admin/category', [Category_Controller::class, 'index'])->name('admin.category');
Route::post('/admin/addCategory', [Category_Controller::class, 'store']);
Route::get('/admin/category/{id}/edit', [Category_Controller::class, 'edit'])->name('admin.category.edit');
Route::put('/admin/category/{id}', [Category_Controller::class, 'update']);
Route::delete('/admin/category/{id}', [Category_Controller::class, 'destroy']);


Route::get('/forgot-password', [Auth_Controller::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/send-reset-link-email', [Auth_Controller::class, 'sendResetLinkEmail'])->name('send.reset.link.email');
route::get('/reset-password/{email}/{token}', [Auth_Controller::class, 'formForgot'])->name('reset-password');
Route::post('/reset-password', [Auth_Controller::class, 'reset'])->name('password.update');

Route::get('/admin/forgot-password', [User_Controller::class, 'showForgotPasswordForm'])->name('admin.forgot-password');
Route::post('/admin/send-reset-link-email', [User_Controller::class, 'sendResetLinkEmail'])->name('admin.send.reset.link.email');
route::get('/admin/reset-password/{email}/{token}', [User_Controller::class, 'formForgot'])->name('admin.reset-password');
Route::post('/admin/reset-password', [User_Controller::class, 'reset'])->name('admin.password.update');

