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
    public function index(){
       
        return view('admin.index');
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