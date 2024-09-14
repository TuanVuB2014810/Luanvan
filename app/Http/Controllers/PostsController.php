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

class PostsController extends Controller
{
    public function index()
    {
        $posts = DB::table('phongtro')

            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')
            ->select('phongtro.*', 'posts.*', 'images.image')
            ->orderBy('phongtro.phongtro_id', 'asc')
            ->get();
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
        }
        $PostMostfav = $this->PostMostfav();
        $PostLast = $this->GetPostLast();

        // dd($PostMostfav);
        return view(
            'user.index',
            [
                'post' => $posts,
                'PostMostfav' => $PostMostfav,
                'PostLast' => $PostLast,
            ]
        );
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
        // dd($id);
        $phongtro = new Phongtro();
        $post = new Post();
        $img = new Image();
        $phongtro = $phongtro::where('maphong', $id)->delete();
        $phongtro_id = DB::table('phongtro')->where('maphong', $id)->select('phongtro_id')->first();
        $img = $img::where('phongtro_id', $phongtro_id)->delete();

        $post = $post::where('maphong', $id)->delete();
        // $phongtro->delete();
        // dd($id);
        return redirect('/ql_dangbai')->with('success_del', 'Xóa bài thành công.');
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
        $postAddress = $this->PostAddress($post->huyen);

        $total_rating = db::table('evaluates')
            ->where('phongtro_id', $post->phongtro_id)
            ->selectRaw('COUNT(*) as total_ratings, AVG(rating) as average_rating')
            ->first();

        $post->gia = Format::format_currency($post->gia);
        $post->gia_dien = Format::format_currency($post->gia_dien);
        $post->gia_nuoc = Format::format_currency($post->gia_nuoc);

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
        ]);
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
    private function PostAddress($huyen)
    {
        $posts = DB::table('phongtro')
            ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
            ->leftJoin('images', function ($join) {
                $join->on('phongtro.phongtro_id', '=', 'images.phongtro_id')
                    ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE images.phongtro_id = phongtro.phongtro_id)');
            })
            ->where('status', '1')
            ->where('phongtro.huyen', $huyen)
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
           
            ->select('phongtro.dientich', 'phongtro.gia', 'posts.maphong', 'posts.content', 'images.image', DB::raw('COUNT(listwish.id) as favorite_count'))
            ->groupBy('phongtro.dientich', 'phongtro.gia', 'posts.maphong', 'posts.content', 'images.image') // Nhóm kết quả theo các cột cần thiết
            ->orderByDesc('favorite_count') 
            ->take(8) 
            ->get();
        // dd($posts);
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
        }

        return $posts;
    }


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
            ->get();
        $tenloai = DB::table('loaiphong')
            ->where('id', '=', $type)->select('loaiphong.name')->first();
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
        }
        return view('user.index', ['post' => $posts, 'tenloai' => $tenloai]);
    }
    public function findPostReco(Request $request)
    {
        dd($request->all());
    }
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
        }
        $tukhoa = $request->tukhoa;
        return view('user.findPost', ['find' => $posts, 'tukhoa' => $tukhoa]);
    }
    public function AddFavorite($id)
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
                    if ($lwish->yeuthich == 0) {
                        $lwish = DB::table('listwish')->update([
                            'yeuthich' => 1,
                        ]);
                    } else {
                        $lwish = DB::table('listwish')->update([
                            'yeuthich' => 0,
                        ]);
                    }
                } else {
                    $lwish = new listwish();
                    $lwish->post_id = $post->id;
                    $lwish->user_id = $user_id->user_id;
                    $lwish->yeuthich = 1;
                    $lwish->save();
                }
                // $kq = $this->Post_detail_user($id);
                return redirect()->back();
            }
        } else {
            return redirect('/login');
        }
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
        }
        return view('user.listwish')->with('posts', $post);
    }

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
        }
        $minPrice = Format::format_currency($minPrice);
        $maxPrice = Format::format_currency($maxPrice);
        $gia = 'Giá ' . $minPrice . ' - ' . $maxPrice . ' Triệu';
        return view('user.findPost', ['find' => $posts, 'tukhoa' => $gia]);
    }
    public function findPostdt(Request $request)
    {
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
        foreach ($posts as $post) {
            $post->content = Format::textShorten($post->content);
            $post->gia = Format::format_currency($post->gia);
        }
        $gia = 'Diện tích từ ' . $mindt . '-' . $maxdt . ' m²';
        return view('user.findPost', ['find' => $posts, 'tukhoa' => $gia]);
    }

    //danh gia
    public function Evaluate(Request $request, $phongtro_id)
    {
        // dd($request->all());
        $star = $request->input('star');

        $comment = $request->input('comment');


        $user_id = Auth::user();
        if ($user_id) {
            $user_id = $user_id->user_id;
            $check = DB::table('evaluates')->where('user_id', $user_id)->where('phongtro_id', $phongtro_id)->first();
            if (!isset($check)) {
                $danhgia = new evaluate();
                $danhgia->phongtro_id = $phongtro_id;
                $danhgia->user_id = $user_id;
                $danhgia->rating = $star;
                $danhgia->comment = $comment;
                $danhgia->save();
                return redirect()->back()->with('msge', 'Đánh giá thành công.');
            } else {
                return redirect()->back()->with('msge', 'Bạn đã đánh giá trước đó.');
            }
        } else {
            return redirect('/login');
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
        $suggestions = Post::where('content', 'like', $query . '%')->limit(5)->pluck('content');
        return response()->json(['suggestions' => $suggestions]); // Trả về dữ liệu dưới dạng JSON
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