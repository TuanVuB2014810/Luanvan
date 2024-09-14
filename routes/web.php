<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhongtroController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostAdminController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\loaiphongController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\LoginFacebookController;
use App\Http\Controllers\Thongkecontroller;
use App\Http\Controllers\Chatcontroller;


route::get('/admin/login',[AdminController::class,'login'])->name('login-admin');
route::post('/admin/login',[AdminController::class,'postlogon'])->name('admin.logon');
Route::get('/admin', [AdminController::class,'index'])->name('admin-index');
Route::get('/admin/logout', [AdminController::class,'logout']);

route::prefix('admin')->middleware('admin')->group(function (){
    // route::get('/login',[AdminController::class,'login'])->name('login-admin');
    Route::get('/', [AdminController::class,'index'])->name('admin-index');
    Route::get('/Post_detail/{id}', [PostsController::class,'Post_detail'])->name('AdminPost-detail');
    //duyet bai
    Route::get('/ql_dangbai', [PostsController::class,'admin_post'])->name('admin.post');
    Route::post('/ql_dangbai', [PostsController::class,'adminSearchPosts']);

    Route::get('/duyetbai/{id}', [PostAdminController::class,'duyetbai']);
    Route::post('/quan-ly-duyet-bai-an-bai/{id}', [PostAdminController::class,'duyetbaiAn']);

    Route::get('/chitiet_baidang/{id}', [PostsController::class,'Post_detail'])->name('bai_dang_admin');
    // quan ly loai
    Route::get('/ql_loai', [loaiphongController::class,'index']);
    Route::get('/ql_loai-create', [loaiphongController::class,'create']);
    Route::post('/ql_loai-store', [loaiphongController::class,'store']);
    Route::get('/ql_loai/edit/{id}', [loaiphongController::class,'edit']);
    Route::PUT('/ql_loai/edit/{id}', [loaiphongController::class,'update']);
    Route::delete('/ql_loai/delete/{id}', [loaiphongController::class,'destroy']);
    //xem phong tro 
    Route::get('/ql_phongtro', [PhongtroController::class,'index']);
    //quan ly nguoi dung
    Route::get('/ql_user', [UserController::class,'ql_user']);
    //quan ly thong tin admin
    Route::get('/adminProfile', [AdminController::class,'profile'])->name('profileAdmin');
    Route::get('/edit_profileAdmin', [AdminController::class,'editProfileAmin'])->name('edit_profileAdmin');
    Route::PUT('/edit_profileAdmin', [AdminController::class,'updateProfileAdmin']);
    Route::get('/edit_profileAdmin_password', [AdminController::class,'editProfilePassAmin'])->name('edit_profileAdmin_password');
    Route::PUT('/edit_profileAdmin_password', [AdminController::class,'updateProfilePass']);

    Route::get('/thong-ke', [ThongkeController::class,'thongke']);
    Route::post('/thong-ke', [ThongkeController::class,'thongkeThoigian']);

});
// Route::use('', [UserController::class,'getAtv'])->name('avt');
Route::get('/login', [UserController::class,'login_user'])->name('login');
Route::post('/post-login', [UserController::class,'postLogin']);
Route::get('/logout', [UserController::class,'logout'])->name('logout');

Route::get('/register', [UserController::class,'register'])->name('register');
Route::post('/register', [UserController::class,'postRegister']);



Route::middleware('avatar')->group(function () {
    Route::get('/',  [PostsController::class, 'index'])->name('index');
    Route::get('/about', [PagesController::class,'about'])->name('about');

    route::prefix('/ql_dangbai')->group(function (){

        Route::get('/', [PostsController::class,'ql_dangbai'])->name('bai_dang');
        Route::get('/create', [PostsController::class,'listPost'])->name('create_post');
        Route::post('/create', [PostsController::class,'createPost']);
        Route::get('/edit/{id}', [PostsController::class,'editPost']);
        Route::put('/edit/{id}', [PostsController::class,'updatePost']);
        Route::delete('/delete/{id}', [PostsController::class,'delete_post']);
        Route::get('/{status_post}', [PostsController::class,'showStatus']);
        Route::get('/hidden/{id}', [PostsController::class,'addhidden']);
        Route::get('/show/{id}', [PostsController::class,'addshow']);
    });
    //chi tiet bai dang user
    Route::get('/chitiet_baidang/{id}', [PostsController::class,'Post_detail_user'])->name('bai_dang_user');
    
    //tim kiem
    Route::get('/tim-kiem', [PostsController::class,'index']);
    Route::get('/tim-kiem-loai-hinh-thue/{type}', [PostsController::class,'findPostType']);
    Route::post('/tim-kiem', [PostsController::class,'findPostContent']);

    Route::post('/tim-kiem-phong-tro-theo-gia', [PostsController::class,'findPostPrice']);
    Route::post('/tim-kiem-phong-tro-theo-dien-tich', [PostsController::class,'findPostdt']);
    Route::post('/tim-kiem-phong-tro-theo-dia-chi', [PostsController::class,'findPostAddr']);

    //goi y tim kiem
    Route::get('/tim-kiem-suggestions', [PostsController::class,'suggestions'])->name('search.suggestions');

    
    //profile
route::middleware('auth')->group(function (){
    Route::get('/profile', [UserController::class,'profile']);
    Route::PUT('/profile', [UserController::class,'editAvt']);
    Route::get('/edit-profile', [UserController::class,'editProfile']);
    Route::PUT('/edit-profile', [UserController::class,'updateProfile']);
    Route::get('/edit-profile-password', [UserController::class,'editProfilePass']);
    Route::PUT('/edit-profile-password', [UserController::class,'updateProfilePass']);
    // bai yeu thich
    Route::get('/them-yeu-thich/{id}', [PostsController::class,'AddFavorite']);
    Route::get('/wishList', [PostsController::class,'wishListUser']);
});
  

    //show profile cumtomer
    Route::get('/user/detailUser/{id}', [PostsController::class,'detailUserPost']);
    
    
   
    
    // đánh giá
    Route::post('/danhgia-phongtro/{phongtro_id}', [PostsController::class,'Evaluate']);
    // login gg fb
    Route::get('/auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);

    Route::get('/auth/facebook', [LoginFacebookController::class,'redirectToFacebook'])->name('auth.facebook');
    Route::get('/auth/facebook/callback', [LoginFacebookController::class,'handleFacebookCallback']);
  


    Route::fallback(function () {
       
        return view('user.error');
    });

});



//quan ly dang bai user