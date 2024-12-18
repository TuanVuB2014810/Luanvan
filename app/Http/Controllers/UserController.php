<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use function PHPUnit\Framework\directoryExists;
use App\Helpers\Format;
class UserController extends Controller
{
    // public function __construct()
    // {
    //     // Áp dụng middleware 'auth' cho tất cả các phương thức trong controller
    //     $this->middleware('auth');

    //     // Áp dụng middleware 'admin.auth' cho các phương thức cụ thể
    //     $this->middleware('auth')->only(['postLogin', 'logout',]);
    // }
    public function ql_user(){
        $u = DB::table('users')->where('role','0')->select('user_id','users.name','users.phone','users.city','users.email','users.google_id','users.facebook_id')->get();
        return view('admin.user',[
            'users'  => $u ,
        ]);
    }
    public function login_user(){
       
        return view('user.login');
    }
    public function register(){
       
        return view('user.register');
    }
    public function postRegister(Request $request){
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'pass' => 'required|min:6',
            'phone' => 'required|unique:users,phone',
            'city' => 'required',
        ], [
            'name.required' => 'Vui lòng nhập tên người dùng.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'name.unique' => 'Tên người dùng đã được sử dụng.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'pass.required' => 'Vui lòng nhập mật khẩu.',
            'pass.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'city.required' => 'Vui lòng nhập thành phố.',
        ]);
       
        $request->merge(['pass'=>Hash::make($request->pass)]);
        // dd($request->all());
        // try{
        //  User::created($request->all);
         $u = new User();
         $u->name = $request->input('name');
         $u->email = $request->input('email');
         $u->password = $request->input('pass');
         $u->phone = $request->input('phone');
         $nowInVietnam = Carbon::now();
         $u->date_create =$nowInVietnam;
        $u->avt = 'nen.png';
         $u->city = $request->input('city'); 
         $u->save();
        // }
        // catch(\Throwable $th){
        // dd($th);
        // }
        return redirect()->route('register')->with('success', 'Bạn đã tạo tài khoản thành công!');
    }
    public function postLogin(Request $request){
       
        $request->validate([
            'name' => 'required',
            'pass' => 'required|min:6',
        ], [
            'name.required' => 'Vui lòng nhập tên người dùng.',
            'pass.required' => 'Vui lòng nhập mật khẩu.',
            'pass.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        ]);
        if(Auth::attempt(['name'=>$request->name,'password'=>$request->pass,])){
            return  redirect()->route('index');
        }
        return redirect()->back()->with('error','Bạn nhận tên hoặc mật khẩu sai, vui lòng thử lại.');
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
        }
    public function profile(){
        $user = Auth::user();
        $user = DB::table('users')->where('user_id','=',Auth::user()->user_id)->first();
        Date::setLocale('vi'); 
        // $post->date_create->setTimezone('Asia/Ho_Chi_Minh');
        $created_at = Carbon::parse($user->date_create);
        $created_at->setTimezone('Asia/Ho_Chi_Minh');
        $posts = $this->showPostUser($user->user_id);
        $msg = "Chưa cung cấp";
        $user->city =$user->city ?? $msg;
        $user->phone =$user->phone ?? $msg;
        $user->avt =$user->avt ?? 'nen.png';
        // dd($user);
        $nowInVietnam = Carbon::now('Asia/Ho_Chi_Minh');
        $timeSinceCreation = $created_at->diffForHumans($nowInVietnam);
        return view('user.profile.profile',['user' => $user, 'time'=>$timeSinceCreation,'posts'=>$posts]);
    }
    private function showPostUser($id) {
        $posts = DB::table('phongtro')
                ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
                ->join('users','users.user_id','=','posts.user_id')
                ->leftJoin('images', function ($join) {
                    $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                        ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
                })
                ->where('posts.user_id',$id)
                ->select('phongtro.*', 'phongtro.name', 'posts.*', 'images.image',)
                ->orderBy('phongtro.phongtro_id', 'asc')
                ->take(6)
                ->get();
        foreach($posts as $post){
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
            $total_rating = $this->getTotalRating($post->phongtro_id);
            $post->total_rating = $total_rating;
        }
        $posts = collect($posts)->sortByDesc(function ($post) {
            return $post->total_rating->average_rating ?? 0; // Sắp xếp theo total_rating (lấy giá trị trung bình)
        });
        
        return $posts;
    }
    public function getTotalRating($phongtro_id)
{
    // Lấy tổng số đánh giá và sao trung bình từ cơ sở dữ liệu
    $totalRating = DB::table('evaluates')
        ->where('phongtro_id', $phongtro_id)
        ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as average_rating')
        ->first();

    // Kiểm tra nếu có dữ liệu
    if ($totalRating) {
        return $totalRating; // Trả về trực tiếp tổng số đánh giá và sao trung bình
    } else {
        return (object) ['average_rating' => 0, 'total_ratings' => 0]; // Nếu không có đánh giá nào
    }
}
    public function editProfile(){
     
        $user = DB::table('users')->where('user_id','=',Auth::user()->user_id)->first();
        return view('user.profile.editProfile')->with('user',$user);
    }
    public function  updateProfile(Request  $request){

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
    public function editProfilePass(){
    // dd(Auth::user());
    $user = DB::table('users')->where('user_id','=',Auth::user()->user_id)->first();
    return view('user.profile.editPassword')->with('user',$user);
    }

    public function updateProfilePass(Request $request)
    {   
        // Validate the request data
    


        try {
            $request->validate([
                'currentPassword' => 'required',
                // 'newPassword' => 'required|min:8', 
                'confirmPassword' => 'required|same:newPassword',
            ]);
        
            // Kiểm tra xem mật khẩu hiện tại có đúng không
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
        
            // In ra thông báo lỗi của trường 'confirmPassword'
            if ($errors->has('confirmPassword')) {
                $errorMessage = 'Xác nhận mật khẩu không khớp với mật khẩu mới.';
                return redirect()->back()->with('msg_err', $errorMessage);
            }
            
        }
    }
   

public function editAvt( Request $request ){
    // dd($request->file('image'));
    $image = $request->file('image_avt');
    $randomImg = random_int(1000,9999);
    if ($image) {
        $temporaryPath = $image->getClientOriginalName(); // Lấy đường dẫn tạm thời của tệp ảnh
        $anh='avt_image'.time().'_'.$randomImg.'.'.$temporaryPath;
        $image->move(public_path('images'),$anh); 
        $u = DB::table('users')->where('user_id','=',Auth::user()->user_id)
        ->update([
            'avt'=>$anh,
        ]);
        return redirect()->back();
    } else {
      return redirect()->back()->with('msgErrAvt','không thể thay đổi ảnh đại diện.');
    }
   
}
public function destroy($id)
{
    $deleted = User::where('user_id', $id)->delete();

    if ($deleted) {
        return response()->json(['success' => 'Xóa thành công']);
    }

    return response()->json(['error' => 'Xóa thất bại'], 500);
}


}