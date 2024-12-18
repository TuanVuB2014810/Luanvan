<?php

namespace App\Http\Controllers;

use App\Models\evaluate;
use App\Models\Phongtro;
use App\Models\Post;
use App\Models\loaiphong;
use App\Models\image;
use App\Models\listwish;
use App\Helpers\Format;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use CarbonCarbon;
use Jenssegers\Date\Date;
use GuzzleHttp\Client;

class PostsController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('query'); // Lấy giá trị tìm kiếm từ query string

    // Lấy tất cả dữ liệu bài đăng
    $posts = DB::table('phongtro')
        ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
        ->leftJoin('images', function ($join) {
            $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
        })
        ->where('status', '1');

    // Thêm điều kiện tìm kiếm nếu có query
    if ($query) {
        $posts->where('posts.content', 'like', '%' . $query . '%'); // Tìm kiếm theo nội dung bài đăng
    }

    $posts = $posts->select('phongtro.*', 'posts.*', 'images.image')
        ->get(); // Lấy tất cả bài đăng phù hợp

    // Xử lý và thêm thông tin như content rút gọn, giá tiền, và tổng số sao
    foreach ($posts as $post) {
        $post->content = Format::textShorten($post->content);
        $post->gia = Format::format_currency($post->gia);

        // Lấy total rating cho mỗi bài đăng
        $total_rating = $this->getTotalRating($post->phongtro_id);
        $post->total_rating = $total_rating;
    }

    // Sắp xếp bài đăng theo số sao từ cao xuống thấp
    $sortedPosts = collect($posts)->sortByDesc(function ($post) {
        return $post->total_rating->average_rating ?? 0; 
    });

    // Phân trang 
    $currentPage = $request->input('page', 1); 
    $perPage = 5; // Số bài đăng mỗi trang
    $paginatedPosts = new \Illuminate\Pagination\LengthAwarePaginator(
        $sortedPosts->forPage($currentPage, $perPage), // Lấy các bài đăng tương ứng với trang hiện tại
        $sortedPosts->count(), // Tổng số bài đăng
        $perPage, // Số bài đăng mỗi trang
        $currentPage, // Trang hiện tại
        ['path' => $request->url(), 'query' => array_merge($request->query(), ['query' => $query])] // Thêm giá trị query để giữ lại trong URL khi phân trang
    );

    // Lấy các bài đăng phổ biến và bài đăng mới nhất
    $PostMostfav = $this->PostMostfav();
    $PostLast = $this->GetPostLast();

    // Trả về view với dữ liệu đã phân trang và tìm kiếm
    return view('user.index', [
        'post' => $paginatedPosts, // Truyền bài đăng đã phân trang
        'PostMostfav' => $PostMostfav,
        'PostLast' => $PostLast,
        'query' => $query, // Truyền giá trị query vào view để hiển thị trong ô tìm kiếm
    ]);
}

    
    public function GetPostLast(){
         $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')

            ->select('phongtro.*', 'phongtro.name', 'posts.*', 'images.image',)
            ->orderBy('phongtro.phongtro_id', 'desc')
            ->take(8)
            ->get();
        // dd($posts);
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content,40);
            $post->gia = Format::format_currency($post->gia);

            $total_rating = $this->getTotalRating($post->phongtro_id);
            $post->total_rating = $total_rating;
        }
        return $posts;
    }
    public function ql_dangbai()
    {


        if (isset(Auth::user()->user_id)) {
            $user_id = Auth::user()->user_id;
            $post = Post::all();
            $post = $post->where('user_id', $user_id);
            return view('user/posts/post', ['post' => $post,]);
        } else
            return redirect('/login');
    }
    public function listPost()
    {
        $loai = Loaiphong::all();
        return view('user/posts/postAdd')->with('loai', $loai);
    }
    public function createPost(Request $request)
    {
        // dd($request->all());
        $user_id = Auth::user()->user_id;
        $maphong = rand(1001, 9999);
        $nowInVietnam = Carbon::now();
        $post = new Post();
        $post->user_id = $user_id;
        $post->content = $request->input('content');
        $post->maphong = $maphong;
        $post->date_create = $nowInVietnam;
        $post->date_update = $nowInVietnam;

        $phongtro = new Phongtro();
        $phongtro->name = $request->input('name');
        $phongtro->sophong = $request->input('sophong');
        $phongtro->mota = nl2br($request->input('mota'));
        $phongtro->gia = $request->input('gia');
        $phongtro->gia_nuoc = $request->input('gia_nuoc');
        $phongtro->gia_dien = $request->input('gia_nuoc');
        $phongtro->dientich = $request->input('dientich');
        $phongtro->maphong = $maphong;
        $phongtro->dia_chi = $request->dia_chi;
        $phongtro->tinh = $request->calc_shipping_provinces;
        $phongtro->huyen = $request->calc_shipping_district;

        $phongtro->loai_phong = $request->input('type');

        $phongtro->save();
        // dd($phongtro);
        $post->save();

        $uploadedFiles = $request->file('images');
        $phongtroid = DB::table('phongtro')->where('maphong', '=', $maphong)->select('phongtro.phongtro_id')->first();
        foreach ($uploadedFiles as $file) {
            $randomImg = random_int(1000, 9999);
            $image = new Image;
            $anh = 'image' . time() . '_' . $randomImg . '.' . $file->extension();
            $file->move(public_path('images'), $anh);
            $image = Image::create([
                'phongtro_id' => $phongtroid->phongtro_id,
                'image' => $anh,
            ]);
            $image->save();
        }
        return redirect('/ql_dangbai')->with('msg', 'Thêm thành công');
    }
    public function editPost($id)
    {
        $post = new Post;
        $loai = Loaiphong::all();
        $result = get_object_vars($loai);
        // dd($loai);
        $post = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->join('images', 'phongtro.phongtro_id', 'images.phongtro_id')
            ->join('loaiphong', 'loaiphong.id', 'phongtro.loai_phong')
            ->where('posts.maphong', '=', $id)
            ->select('phongtro.*', 'loaiphong.name as tenloai', 'posts.*', 'images.image')
            ->first();
        // dd($post);
        if ($post) {
            return view('/user/posts/edit', [
                'post' => $post,
                'loai' => $loai,
            ]);
        } else {
            $msg_err = "<script> confirm('không tồn tại nhà trọ này')</script>";
            return redirect('/ql_dangbai')->with('msg_err', $msg_err);
        }

        //  return view('/user/posts/edit');
    }
    public function updatePost(Request $request, $id)
    {
        $phongtro = new Phongtro();
        $phongtro = $phongtro::where('maphong', $id)
            ->update([
                'name' => $request->input('name'),
                'sophong' => $request->input('sl'),
                'gia' => $request->input('gia'),
                'gia_nuoc' => $request->input('gia_nuoc'),
                'gia_dien' => $request->input('gia_dien'),
                'mota' => nl2br($request->input('desc')),
                'loai_phong' => $request->input('type'),
                'dientich' => $request->input('dientich'),
                'dia_chi' => $request->dia_chi,
                'tinh' => $request->calc_shipping_provinces,
                'huyen' => $request->calc_shipping_district,
            ]);
        $post = new post();
        $post = $post::where('maphong', $id)
            ->update([
                'content' => $request->input('content'),
                'status' => '0',
            ]);
        $uploadedFiles = $request->file('images');
        if ($uploadedFiles) {
            $phongtroid = DB::table('phongtro')->where('maphong', '=', $id)->select('phongtro.phongtro_id')->first();
            $img = new Image();
            $img = $img::where('phongtro_id', $phongtroid->phongtro_id)->delete();
            foreach ($uploadedFiles as $file) {
                $randomImg = random_int(1000, 9999);
                $image = new Image;
                $anh = 'image' . time() . '_' . $randomImg . '.' . $file->extension();
                $file->move(public_path('images'), $anh);
                $image = Image::create([
                    'phongtro_id' => $phongtroid->phongtro_id,
                    'image' => $anh,
                ]);
                $image->save();
            }
        }
        return redirect('/ql_dangbai')->with('msg', 'Chỉnh sửa thành công');
    }
    public function delete_post($id)
{
    try {
        // Xóa các thông tin liên quan đến bài đăng
        $phongtro = Phongtro::where('maphong', $id)->delete();
        $phongtro_id = DB::table('phongtro')->where('maphong', $id)->select('phongtro_id')->first();
        if ($phongtro_id) {
            Image::where('phongtro_id', $phongtro_id->phongtro_id)->delete();
        }
        Post::where('maphong', $id)->delete();

        // Trả về phản hồi JSON
        return response()->json(['success' => 'Xóa bài đăng thành công.']);
    } catch (\Exception $e) {
        // Xử lý lỗi và trả về phản hồi JSON
        return response()->json(['error' => 'Đã xảy ra lỗi. Không thể xóa bài.'], 500);
    }
}

    public function admin_post()
    {
        $post = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->join('users', 'users.user_id', '=', 'posts.user_id')
            ->select('phongtro.*', 'posts.*', 'users.*')
            ->get();
        return view('admin/post/adminPost', ['post' => $post,]);
    }

    public function Post_detail($id)
    {
        $post = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->join('users', 'users.user_id', '=', 'posts.user_id')
            ->join('loaiphong', 'loaiphong.id', '=', 'phongtro.loai_phong')
            ->join('images', 'phongtro.phongtro_id', 'images.phongtro_id')
            ->where('posts.maphong', '=', $id)
            ->select('phongtro.*', 'posts.*', 'users.name as tennguoi', 'users.*', 'loaiphong.name as tenloai', 'images.*')
            ->first();
        // $post = DB::table('phongtro')
        $allImg = $this->show_image($id);
        Date::setLocale('vi');
        $created_at = Carbon::parse($post->created_at);
        $timeSinceCreation = $created_at->diffForHumans();

        $posts = $this->showPostUser($post->user_id);
        // dd($timeSinceCreation);
        return view('admin/post/postDetail_admin', ['post' => $post, 'time' => $timeSinceCreation, 'posts' => $posts, 'allimage' => $allImg,]);
    }
    public function Post_detail_user($id)
    {
        $post = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->join('users', 'users.user_id', '=', 'posts.user_id')
            ->join('loaiphong', 'loaiphong.id', '=', 'phongtro.loai_phong')
            ->join('images', 'phongtro.phongtro_id', 'images.phongtro_id')
            ->where('posts.maphong', '=', $id)
            ->select('phongtro.*', 'posts.*', 'users.city as addressUser', 'users.name as tennguoi', 'users.date_create as ngaytao', 'users.*', 'loaiphong.name as tenloai', 'images.*')
            ->first();
        // $post = DB::table('phongtro')

        $allImg = $this->show_image($id);
        Date::setLocale('vi');
        // $post->date_create->setTimezone('Asia/Ho_Chi_Minh');
        $created_at = Carbon::parse($post->date_create);
        $post->ngaytao = Carbon::parse($post->ngaytao);
        $created_at->setTimezone('Asia/Ho_Chi_Minh');
        $post->ngaytao->setTimezone('Asia/Ho_Chi_Minh');

        $nowInVietnam = Carbon::now('Asia/Ho_Chi_Minh');
        $timeSinceCreation = $created_at->diffForHumans($nowInVietnam);
        $post->ngaytao = $post->ngaytao->diffForHumans($nowInVietnam);
        $posts = $this->showPostUser($post->user_id);
        $evaluates = $this->showEvaluate($post->phongtro_id);
        $listwish = $this->showfavorite($id);
        $userList = $this->usersameAddress($post->addressUser);
        $postAddress = $this->PostAddress($post->huyen, $id);

        $total_rating = db::table('evaluates')
            ->where('phongtro_id', $post->phongtro_id)
            ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as average_rating')
            ->first();

        $post->gia = Format::format_currency($post->gia);
        $post->gia_dien = Format::format_currency($post->gia_dien);
        $post->gia_nuoc = Format::format_currency($post->gia_nuoc);
        $phongTro = DB::table('phongtro')->where('maphong', $id)->first();
        $diaChi = urlencode($phongTro->dia_chi . ', ' . $phongTro->huyen . ', ' . $phongTro->tinh);
        $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query=" . $diaChi;
        // dd($userList);
        // dd($evaluates);
        // dd($timeSinceCreation);
        
        
        return view('user.detailPost', [
            'post' => $post,
            'time' => $timeSinceCreation,
            'posts' => $posts,
            'allimage' => $allImg,
            'evaluates' => $evaluates,
            'listwish' => $listwish,
            'userList' => $userList,
            'postAddress' => $postAddress,
            'total_rating' => $total_rating,
            'googleMapsUrl' => $googleMapsUrl,
            // 'coordinates' => $coordinates,
        ]);
    }
  
    // public function getTotalRating($phongtro_id)
    // {
    //     // Lấy tổng số đánh giá và sao trung bình từ cơ sở dữ liệu
    //     $totalRating = DB::table('evaluates')
    //         ->where('phongtro_id', $phongtro_id)
    //         ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as average_rating')
    //         ->first();

    //     // Kiểm tra nếu có dữ liệu
    //     if ($totalRating) {
    //         return response()->json([
    //             'average_rating' => $totalRating->average_rating,
    //             'total_ratings' => $totalRating->total_ratings
    //         ]);
    //     } else {
    //         return response()->json([
    //             'average_rating' => 0,
    //             'total_ratings' => 0
    //         ]);
    //     }
    // }
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
public function getRatingData($ma_phong)
{
    // Tìm 'phongtro_id' từ bảng 'phongtro' dựa trên 'maphong'
    $phongtro = DB::table('phongtro')->where('maphong', $ma_phong)->first();

    if (!$phongtro) {
        // Nếu không tìm thấy phòng trọ, trả về giá trị mặc định
        return response()->json([
            'five_star' => 0,
            'four_star' => 0,
            'three_star' => 0,
            'two_star' => 0,
            'one_star' => 0,
        ]);
    }

    // Lấy đánh giá từ bảng 'evaluates' dựa trên 'phongtro_id'
    $ratings = DB::table('evaluates')
        ->where('phongtro_id', $phongtro->phongtro_id) // Sử dụng đúng 'phongtro_id'
        ->selectRaw('
            COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star,
            COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star,
            COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star,
            COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star,
            COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
        ')
        ->first();

    // Trả về kết quả đánh giá dưới dạng JSON
    return response()->json($ratings);
}





    private function usersameAddress($add)
    {
        $users = DB::table('users')
            ->where('city', 'like', '%' . $add . '%')
            ->select('users.user_id', 'users.name', 'users.avt', 'users.city', 'users.phone')
            ->get();
        foreach ($users as $user) {
            $user->avt = $user->avt ?? 'nen.png';
        }
        return $users;
    }
    private function showPostUser($id)
    {
        $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->join('users', 'users.user_id', '=', 'posts.user_id')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')

            ->where('posts.user_id', $id)
            ->select('phongtro.*', 'phongtro.name', 'posts.*', 'images.image',)
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->take(8)
            ->get();
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
        }



        return $posts;
    }
    private function show_image($maphong)
    {
        $img = DB::table('Images')->join('phongtro', 'phongtro.phongtro_id', '=', 'Images.phongtro_id')
            ->where('phongtro.maphong', '=', $maphong)->select('images.*')->get();
        return $img;
    }
    private function PostAddress($huyen, $id)
    {
        $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')
            ->where('phongtro.huyen', $huyen)
            ->where('posts.maphong', '!=', $id)
            ->select('phongtro.*', 'phongtro.name', 'posts.*', 'images.image',)
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->take(8)
            ->get();
        // dd($posts);
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
        }
        return $posts;
    }
    private function PostMostfav()
    {
        $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->leftJoin('listwish', 'posts.id', '=', 'listwish.post_id')
            ->where('listwish.yeuthich', 1) 
            ->where('status', '1')
           
            ->select('phongtro.phongtro_id','phongtro.dientich', 'phongtro.dia_chi','phongtro.huyen','phongtro.tinh','phongtro.gia', 'posts.maphong', 'posts.content', 'images.image', DB::raw('COUNT(listwish.id) as favorite_count'))
            ->groupBy('phongtro.phongtro_id','phongtro.dientich',  'phongtro.dia_chi','phongtro.huyen','phongtro.tinh','phongtro.gia', 'posts.maphong', 'posts.content', 'images.image') // Nhóm kết quả theo các cột cần thiết
            ->orderByDesc('favorite_count') 
            ->take(8) 
            ->get();
        // dd($posts);
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content,40);
            $post->gia = Format::format_currency($post->gia);
            $total_rating = $this->getTotalRating($post->phongtro_id);
            $post->total_rating = $total_rating;
        }

        return $posts;
    }
   
    private function textShorten($text, $limit = 100)
    {
        if (strlen($text) > $limit) {
            return substr($text, 0, $limit) . '...';
        }

        return $text;
    }
// lọc theo loại
    
    public function findPostType($type)
    {
        $posts = DB::table('phongtro')
            ->join('loaiphong', 'loaiphong.id', '=', 'phongtro.loai_phong')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')

            ->where('phongtro.loai_phong', '=', $type)
            ->select('phongtro.*', 'posts.*', 'images.image', 'loaiphong.name as tenloai')
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->paginate(5);
        $tenloai = DB::table('loaiphong')
            ->where('id', '=', $type)->select('loaiphong.name')->first();
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
            $total_rating = $this->getTotalRating($post->phongtro_id);
            $post->total_rating = $total_rating; // Lưu vào biến bài đăng
        }
        return view('user.index', ['post' => $posts, 'tenloai' => $tenloai]);
    }
    public function findPostReco(Request $request)
    {
        dd($request->all());
    }
    // Lọc theo địa chỉ
    public function findPostAddr(Request $request)
    {
        // dd($request->all());
        $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')

            ->where('phongtro.huyen', 'like', '%' . $request->calc_shipping_district . '%')
            ->where('phongtro.tinh', 'like', '%' . $request->calc_shipping_provinces . '%')
            ->select('phongtro.*', 'posts.*', 'images.image',)
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->get();
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);

            $total_rating = $this->getTotalRating($post->phongtro_id);
            $post->total_rating = $total_rating;
        }
        $tukhoa = $request->calc_shipping_district . ", " . $request->calc_shipping_provinces;
        // dd($posts);
        return view('user.findPost', ['find' => $posts, 'tukhoa' => $tukhoa]);
    }
    public function findPostContent(Request $request)
    {
        // dd($request->all());
        $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')

            ->where('posts.content', 'like', '%' . $request->tukhoa . '%')
            ->select('phongtro.*', 'posts.*', 'images.image',)
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->get();
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);

            $total_rating = $this->getTotalRating($post->phongtro_id);
            $post->total_rating = $total_rating;
        }
        $tukhoa = $request->tukhoa;
        return view('user.findPost', ['find' => $posts, 'tukhoa' => $tukhoa]);
    }
    // lọc nhiều điều kiện
    public function findPost(Request $request)
{
    $minPrice = $request->input('minPrice') ? intval($request->input('minPrice')) : null;
    $maxPrice = $request->input('maxPrice') ? intval($request->input('maxPrice')) : null;
    $minArea = $request->input('mindt') ? intval($request->input('mindt')) : null;
    $maxArea = $request->input('maxdt') ? intval($request->input('maxdt')) : null;
    $district = $request->input('calc_shipping_district');
    $province = $request->input('calc_shipping_provinces');

    // Bắt đầu query
    $query = DB::table('phongtro')
        ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
        ->leftJoin('images', function ($join) {
            $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
        })
        ->where('status', '1');

    // Thêm điều kiện lọc giá 
    if (!is_null($minPrice) && !is_null($maxPrice)) {
        $query->whereBetween('phongtro.gia', [$minPrice, $maxPrice]);
    } elseif (!is_null($minPrice)) {
        $query->where('phongtro.gia', '>=', $minPrice);
    } elseif (!is_null($maxPrice)) {
        $query->where('phongtro.gia', '<=', $maxPrice);
    }

    // Thêm điều kiện lọc diện tích 
    if (!is_null($minArea) && !is_null($maxArea)) {
        $query->whereBetween('phongtro.dientich', [$minArea, $maxArea]);
    } elseif (!is_null($minArea)) {
        $query->where('phongtro.dientich', '>=', $minArea);
    } elseif (!is_null($maxArea)) {
        $query->where('phongtro.dientich', '<=', $maxArea);
    }

    // Thêm điều kiện lọc địa chỉ 
    if ($district) {
        $query->where('phongtro.huyen', 'like', '%' . $district . '%');
    }
    if ($province) {
        $query->where('phongtro.tinh', 'like', '%' . $province . '%');
    }

    // Thực thi query và lấy dữ liệu
    $posts = $query->select('phongtro.*', 'posts.*', 'images.image')
        ->orderBy('phongtro.phongtro_id', 'asc')
        ->get();

    // Xử lý dữ liệu
    foreach ($posts as $post) {
        $post->content = Format::textShorten($post->content);
        $post->gia = Format::format_currency($post->gia);

        $total_rating = $this->getTotalRating($post->phongtro_id);
        $post->total_rating = $total_rating;
    }

    // Xây dựng từ khóa tìm kiếm
    $keywords = [];

    // Thêm từ khóa giá nếu có
    
    if ($minPrice || $maxPrice) {
        $priceRange = [];
        if ($minPrice && !$maxPrice) {
            // Chỉ có diện tích tối thiểu
            $keywords[] = 'giá thấp nhất ' . $minPrice . ' VNĐ';
        } elseif (!$minPrice && $maxPrice) {
            // Chỉ có diện tích tối đa
            $keywords[] = 'giá cao nhất ' . $maxPrice . ' VNĐ';
        } elseif ($minPrice && $maxPrice) {
            // Có cả diện tích tối thiểu và tối đa
            $keywords[] = 'giá từ ' . $minPrice . ' VNĐ đến ' . $maxPrice . ' VNĐ';
        }
    }
    // Thêm từ khóa diện tích nếu có
    if ($minArea || $maxArea) {
        $areaRange = [];
        if ($minArea && !$maxArea) {
            // Chỉ có diện tích tối thiểu
            $keywords[] = 'diện tích tối thiểu ' . $minArea . ' m²';
        } elseif (!$minArea && $maxArea) {
            // Chỉ có diện tích tối đa
            $keywords[] = 'diện tích tối đa ' . $maxArea . ' m²';
        } elseif ($minArea && $maxArea) {
            // Có cả diện tích tối thiểu và tối đa
            $keywords[] = 'diện tích từ ' . $minArea . ' m² đến ' . $maxArea . ' m²';
        }
    }
    

    // Thêm từ khóa địa danh nếu có
    if ($district || $province) {
        $location = [];
        if ($district) $location[] = $district;
        if ($province) $location[] = $province;
        $keywords[] = 'ở ' . implode(', ', $location);
    }

    // Loại bỏ phần tử trống và nối các từ khóa
    $tukhoa = implode(' , ', array_filter($keywords));

    // Trả về view
    return view('user.findPost', ['find' => $posts, 'tukhoa' => $tukhoa]);
}


    public function AddFavorite(Request $request, $id)
{
    $user_id = Auth::user();
    if ($user_id) {
        $post = Post::where('maphong', $id)->first();

        if ($post) {
            $lwish = DB::table('listwish')
                ->where('post_id', $post->id)
                ->where('user_id', $user_id->user_id)
                ->first();
            
            if ($lwish) {
                $updatedStatus = ($lwish->yeuthich == 0) ? 1 : 0;
                DB::table('listwish')
                    ->where('post_id', $post->id)
                    ->where('user_id', $user_id->user_id)
                    ->update(['yeuthich' => $updatedStatus]);
            } else {
                DB::table('listwish')->insert([
                    'post_id' => $post->id,
                    'user_id' => $user_id->user_id,
                    'yeuthich' => 1,
                ]);
                $updatedStatus = 1;
            }

            return response()->json(['status' => 'success', 'yeuthich' => $updatedStatus]);
        }
    }
    return response()->json(['status' => 'error']);
}

    public function showfavorite($id)
    {
        $user_id = Auth::user();
        if ($user_id) {
            $post = Post::where('maphong', $id)->first();
            if ($post) {
                $lwish = DB::table('listwish')
                    ->where('post_id', $post->id)
                    ->where('user_id', $user_id->user_id)
                    ->first();
                return $lwish;
            }
        }
        return;
    }
    public function wishListUser()
    {
        $user_id = Auth::user();
        $post = DB::table('phongtro')

            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->join('listwish', 'listwish.post_id', 'posts.id')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')
            ->where('listwish.user_id', $user_id->user_id)
            ->where('listwish.yeuthich', '1')
            ->select('phongtro.*', 'posts.*', 'images.image')
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->get();
        foreach ($post as $p) {
            $p->content = Format::textShorten($p->content);
            $p->gia = Format::format_currency($p->gia);

            $total_rating = $this->getTotalRating($p->phongtro_id);
             $p->total_rating = $total_rating;
        }
        $sortedPosts = $post->sortByDesc('total_rating');
    
        return view('user.listwish')->with('posts', $sortedPosts);
    }
    // lọc theo giá
    public function findPostPrice(Request $request)
    {
        // dd($request->all());
        $minPrice = intval($request->input('minPrice'));
        $maxPrice = intval($request->input('maxPrice'));

        $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')

            ->whereBetween('phongtro.gia', [$minPrice, $maxPrice])
            ->select('phongtro.*', 'posts.*', 'images.image',)
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->get();
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);

            $total_rating = $this->getTotalRating($post->phongtro_id);
            $post->total_rating = $total_rating;
        }
        $minPrice = Format::format_currency($minPrice);
        $maxPrice = Format::format_currency($maxPrice);
        $gia = 'Giá ' . $minPrice . ' - ' . $maxPrice . ' Triệu';
        return view('user.findPost', ['find' => $posts, 'tukhoa' => $gia]);
    }
    public function findPostdt(Request $request)
    {
        //  dd($request->all());
        $mindt = intval($request->input('mindt'));
        $maxdt = intval($request->input('maxdt'));

        $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')

            ->whereBetween('phongtro.dientich', [$mindt, $maxdt])
            ->select('phongtro.*', 'posts.*', 'images.image',)
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->get();
            // dd($posts);
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);

            $total_rating = $this->getTotalRating($post->phongtro_id);
            $post->total_rating = $total_rating;
            // dd($post);
        }
        $gia = 'Diện tích từ ' . $mindt . '-' . $maxdt . ' m²';
        return view('user.findPost', ['find' => $posts, 'tukhoa' => $gia]);
    }

    //danh gia
    public function Evaluate(Request $request, $phongtro_id)
    {
        $star = $request->input('star');
        $comment = $request->input('comment');

        $user = Auth::user();
        if ($user) {
            $user_id = $user->user_id;
            $check = DB::table('evaluates')->where('user_id', $user_id)->where('phongtro_id', $phongtro_id)->first();
            
            if (!isset($check)) {
                $danhgia = new evaluate();
                $danhgia->phongtro_id = $phongtro_id;
                $danhgia->user_id = $user_id;
                $danhgia->rating = $star;
                $danhgia->comment = $comment;
                $danhgia->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Đánh giá thành công.'
                ]);
            } else {
                return response()->json([
                    'status' => 'exists',
                    'message' => 'Bạn đã đánh giá trước đó.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Bạn cần đăng nhập để đánh giá.'
            ]);
        }
    }

    private function showEvaluate($phongtro_id)
    {
        $eva = db::table('evaluates')->join('users', 'users.user_id', '=', 'evaluates.user_id')->where('phongtro_id', $phongtro_id)->select('users.name', 'users.avt', 'evaluates.*')->get();
        foreach ($eva as $user) {
            $user->avt = $user->avt ?? 'nen.png';
        }
        return $eva;
    }
    public function showStatus($status)
    {

        if ($status == 'show') {
            $status = 1;
            $msg = 'Các bài đã đăng';
        } elseif ($status == 'refused') {
            $status = -1;
            $msg = 'Các bài bị từ chối';
        } elseif ($status == 'in-review') {
            $status = 0;
            $msg = 'Các bài đang chờ duyệt';
        } else {
            $status = 2;
            $msg = 'Các bài đã ẩn';
        }

        $posts = DB::table('phongtro')

            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', $status)
            ->where('posts.user_id', Auth::user()->user_id)

            ->select('phongtro.*', 'posts.*', 'images.image')
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->get();
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
        }
        // dd($posts);
        return view('user.posts.postStatus', ['msg_status' => $msg, 'posts' => $posts]);
    }
    public function addhidden($maphong)
    {
        // Find the post by maphong
        $post = Post::where('maphong', $maphong)->first();
        if ($post) {
            if ($post->status == 1) {
                $content = $post->content;
                Post::where('maphong', $maphong)
                    ->update(['status' => 2]);
                $msg = 'Ẩn bài ' . $content . ' bài thành công';
            } else {
                $msg = 'Bài đăng đã nằm trong danh sách ẩn.';
            }
        } else {
            $msg = 'Bài đăng không tồn tại.';
        }
        return redirect()->back()->with('msg', $msg);
    }
    public function addshow($maphong)
    {
        $post = Post::where('maphong', $maphong)->first();
        if ($post) {
            if ($post->status == 2) {
                $content = $post->content;
                Post::where('maphong', $maphong)
                    ->update(['status' => 1]);
                $msg = 'Hiển thị ' . $content . ' bài thành công';
            } else {
                $msg = 'Bài đăng đã nằm trong danh sách đăng.';
            }
        } else {
            $msg = 'Bài đăng không tồn tại.';
        }
        return redirect()->back()->with('msg', $msg);
    }

    public function detailUserPost($id)
    {
        $user = Auth::user();
        $user = DB::table('users')->where('user_id', '=', $id)->first();
        Date::setLocale('vi');
        // $post->date_create->setTimezone('Asia/Ho_Chi_Minh');
        $created_at = Carbon::parse($user->date_create);
        $created_at->setTimezone('Asia/Ho_Chi_Minh');
        $posts = $this->showPostUser($user->user_id);

        $nowInVietnam = Carbon::now('Asia/Ho_Chi_Minh');
        $timeSinceCreation = $created_at->diffForHumans($nowInVietnam);
        return view('user.profile.showProfileUser', ['user' => $user, 'time' => $timeSinceCreation, 'posts' => $posts]);
    }

    public function suggestions(Request $request)
{
    $query = $request->input('query');

    // Kiểm tra nếu query không rỗng
    if($query != '') {
        $suggestions = Post::where('content', 'like', '%' . $query . '%')
            ->limit(5)
            ->pluck('content');
        return response()->json(['suggestions' => $suggestions]);
    } else {
        return response()->json(['suggestions' => []]); // Nếu không có query thì trả về mảng trống
    }
}



    public function adminSearchPosts(Request $request)
    {
        $post = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->join('users', 'users.user_id', '=', 'posts.user_id')
            ->where('posts.content', 'like', '%' . $request->tukhoa . '%')


            ->select('phongtro.*', 'posts.*', 'users.*')
            ->get();
        return view('admin/post/adminPost', ['post' => $post,]);
    }
    
}