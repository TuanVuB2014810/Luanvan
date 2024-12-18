<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Facade;
session_start();
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AdminController extends Controller
{
    // public function __construct()
    // {
    //     // Áp dụng middleware 'auth' cho tất cả các phương thức trong controller
    //     $this->middleware('auth');

    //     // Áp dụng middleware 'admin.auth' cho các phương thức cụ thể
    //     $this->middleware('admin_auth')->only(['postLogin', 'logout',]);
    // }
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }
    public function login(){
       
        return view('admin.login');
    }
    public function postlogon(request $req){
        // dd($req->all());
       if(Auth::attempt(['name' => $req->name,'password'=>$req->pass,'role' =>1])){
        return redirect()->route('admin-index');
       }
       if(Auth::attempt(['name' => $req->name,'password'=>$req->pass,'role' =>0])){
        return redirect()->back()->with('msg','Bạn không có quyền đăng nhập');
       }
       return redirect()->back()->with('msg','sai tên hoặc mật khẩu, vui lòng thử lại');
       
    }
    public function logout(){
           Auth::logout();
        return redirect()->back();
        }
        public function index(Request $request)
        {
            // Lấy dữ liệu người đăng bài nhiều nhất trong tháng/năm
            $userPost = null;
            if ($request->nam && $request->thang) {
                // Nếu có năm và tháng, lấy người đăng bài nhiều nhất trong tháng đó
                $userPost = DB::table('posts')
                    ->join('users', 'users.user_id', '=', 'posts.user_id')
                    ->select('users.user_id', 'users.name', DB::raw('count(posts.id) as total_posts'))
                    ->whereYear('posts.date_create', $request->nam)
                    ->whereMonth('posts.date_create', $request->thang)
                    ->groupBy('users.user_id', 'users.name')
                    ->orderBy('total_posts', 'desc')
                    ->first();
            }
    
            // Lấy số lượng bài đăng, bài duyệt và bài từ chối
            $quantityPost = DB::table('posts')
                ->select(
                    DB::raw('count(posts.id) as total_posts'),
                    DB::raw('SUM(CASE WHEN posts.status = 1 THEN 1 ELSE 0 END) as total_duyet'),
                    DB::raw('SUM(CASE WHEN posts.status = -1 THEN 1 ELSE 0 END) as total_tuchoi')
                )
                ->when($request->nam, function ($query) use ($request) {
                    $query->whereYear('posts.date_create', $request->nam);
                })
                ->when($request->thang, function ($query) use ($request) {
                    $query->whereMonth('posts.date_create', $request->thang);
                })
                ->first();
    
            // Lấy thông tin người dùng, tổng số người dùng và số người dùng đăng bài
            $user = DB::table('users')
                ->select(
                    DB::raw('count(users.user_id) as total_user'),
                    DB::raw('count(DISTINCT posts.user_id) as total_user_in_posts')
                )
                ->leftJoin('posts', 'users.user_id', '=', 'posts.user_id')
                ->where('users.role', '0') // Lọc người dùng có role = 0
                ->when($request->nam, function ($query) use ($request) {
                    $query->whereYear('users.date_create', $request->nam);
                })
                ->when($request->thang, function ($query) use ($request) {
                    $query->whereMonth('users.date_create', $request->thang);
                })
                ->first();
    
            // Tính tỷ lệ người dùng đăng bài
            $user->tyle = $user->total_user ? number_format($user->total_user_in_posts / $user->total_user, 2) : 0;
    
            // Lấy số lượng bài đăng theo từng tháng trong năm
            $monthlyPosts = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthlyPosts[$i] = DB::table('posts')
                    ->whereMonth('date_create', $i)
                    ->whereYear('date_create', $request->nam ?: date('Y'))
                    ->count();
            }
    
            // Trả về view với dữ liệu cần thiết
            return view('admin.index', [
                "userPost" => $userPost,
                "quantityPost" => $quantityPost,
                "user" => $user,
                "monthlyPosts" => $monthlyPosts,
                "nam" => $request->nam,
                "thang" => $request->thang
            ]);
        }
    public function profile(){
        // dd(Auth::user());
        $user = DB::table('users')->where('user_id','=',Auth::user()->user_id)->where('role','1')->first();
        // dd($user);
        return view('admin.profile.profile')->with('userAdmin',$user);
    }
    public function editProfileAmin(){
       
        $user = DB::table('users')->where('user_id','=',Auth::user()->user_id)->first();
        // dd($user);
        return view('admin.profile.editProfile')->with('user',$user);
    }
    public function  updateProfileAdmin(Request  $request){

        $user = DB::table('users')->where('user_id',Auth::user()->user_id)
                                ->update([
                                    'name'=>$request->input('name'),
                                    'email'=>$request->input('email'),
                                    'phone'=>$request->input('phone'),
                                    'city'=>$request->input('city')
                                ]);
        $msg ='Cập nhật thông tin cá nhân thành công';
        $user = DB::table('users')->where('user_id','=',Auth::user()->user_id)->first();
        
        return redirect()->back()->with('msg_update', $msg);
    
    }
    public function editProfilePassAmin(){
    // dd(Auth::user());
    $user = DB::table('users')->where('user_id','=',Auth::user()->user_id)->first();
    return view('admin.profile.editPassword')->with('user',$user);
    }
    public function updateProfilePass(Request $request)
    {   
        try {
            $request->validate([
                'currentPassword' => 'required',
                // 'newPassword' => 'required|min:8', 
                'confirmPassword' => 'required|same:newPassword',
            ]);
          
            if (Hash::check($request->currentPassword, Auth::user()->password)) {
            
                // $user = Auth::user();
            $request->merge(['newPassword'=>Hash::make($request->newPassword)]);
                // $user->save();
                $u = DB::table('users')->where('user_id','=',Auth::user()->user_id)
                                    ->update([
                                        'password'=>$request->newPassword,
                                    ]);
                return redirect()->back()->with('msg_success', ' Đổi mật khẩu thành công');
            } else {
                return redirect()->back()->with('msg_err', ' Sai mật khẩu, thử lại');
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
        
          
            if ($errors->has('confirmPassword')) {
                $errorMessage = 'Xác nhận mật khẩu không khớp với mật khẩu mới.';
                return redirect()->back()->with('msg_err', $errorMessage);
            }
            
        }
    }

}