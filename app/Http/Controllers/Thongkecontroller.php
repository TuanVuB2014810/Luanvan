<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Thongkecontroller extends Controller
{
    public function thongke()
    {
        $userPost = $this->UserPostMax(0, 0);
        $quantityPost = $this->quantityPost(0, 0);
        $user = $this->user(0, 0);

        return view('admin.thongke.thongke', [
            "userPost" => $userPost,
            "quantityPost" => $quantityPost,
            'user' => $user
        ]);
    }
    public function thongkeThoigian(Request $request)
    {

        $userPost = $this->UserPostMax($request->nam, $request->thang);
        $quantityPost = $this->quantityPost($request->nam, $request->thang);
        $user = $this->user($request->nam, $request->thang);
        ;
        return view(
            'admin.thongke.thongke',
            [
                "userPost" => $userPost,
                "quantityPost" => $quantityPost,
                "user" => $user,
                "nam" => $request->nam,
                "thang" => $request->thang
            ]
        );
    }
    public function UserPostMax($nam, $thang)
    {
        if ($nam == 0 && $thang != 0) {
            $userPost = DB::table('posts')
                ->join('users', 'users.user_id', '=', 'posts.user_id')
                ->select('users.user_id', 'users.name', DB::raw('count(posts.id) as total_posts'))
                ->whereMonth('posts.date_create', $thang)
                ->groupBy('users.user_id', 'users.name')
                ->orderBy('total_posts', 'desc')
                ->first();
        } elseif ($thang == 0 && $nam != 0) {

            $userPost = DB::table('posts')
                ->join('users', 'users.user_id', '=', 'posts.user_id')
                ->select('users.user_id', 'users.name', DB::raw('count(posts.id) as total_posts'))
                ->whereYear('posts.date_create', $nam)
                ->groupBy('users.user_id', 'users.name')
                ->orderBy('total_posts', 'desc')
                ->first();
        }
        if ($thang != 0 && $nam != 0) {

            $userPost = DB::table('posts')
                ->join('users', 'users.user_id', '=', 'posts.user_id')
                ->select('users.user_id', 'users.name', DB::raw('count(posts.id) as total_posts'))
                ->whereYear('posts.date_create', $nam)
                ->whereMonth('posts.date_create', $thang)
                ->groupBy('users.user_id', 'users.name')
                ->orderBy('total_posts', 'desc')
                ->first();
        } else {
            $userPost = DB::table('posts')
                ->join('users', 'users.user_id', '=', 'posts.user_id')
                ->select('users.user_id', 'users.name', DB::raw('count(posts.id) as total_posts'))
                ->groupBy('users.user_id', 'users.name')
                ->orderBy('total_posts', 'desc')
                ->first();
        }
        // dd($userPost);
        return $userPost;
    }
    public function quantityPost($nam, $thang)
    {
        if ($nam == 0 && $thang != 0) {
            $quantityPosts = DB::table('posts')
                ->select(
                    DB::raw('count(posts.id) as total_posts'),
                    DB::raw('SUM(CASE WHEN posts.status = 1 THEN 1 ELSE 0 END) as total_duyet'),
                    DB::raw('SUM(CASE WHEN posts.status = -1 THEN 1 ELSE 0 END) as total_tuchoi')
                )
                ->whereMonth('posts.date_create', $thang)
                ->first();

        } elseif ($thang == 0 && $nam != 0) {

            $quantityPosts = DB::table('posts')
                ->select(
                    DB::raw('count(posts.id) as total_posts'),
                    DB::raw('SUM(CASE WHEN posts.status = 1 THEN 1 ELSE 0 END) as total_duyet'),
                    DB::raw('SUM(CASE WHEN posts.status = -1 THEN 1 ELSE 0 END) as total_tuchoi')
                )
                ->whereYear('posts.date_create', $nam)
                ->first();

        } elseif ($thang != 0 && $nam != 0) {

            $quantityPosts = DB::table('posts')
                ->select(
                    DB::raw('count(posts.id) as total_posts'),
                    DB::raw('SUM(CASE WHEN posts.status = 1 THEN 1 ELSE 0 END) as total_duyet'),
                    DB::raw('SUM(CASE WHEN posts.status = -1 THEN 1 ELSE 0 END) as total_tuchoi')
                )
                ->whereYear('posts.date_create', $nam)
                ->whereMonth('posts.date_create', $thang)
                ->first();


        } else {
            $quantityPosts = DB::table('posts')
                ->select(
                    DB::raw('count(posts.id) as total_posts'),
                    DB::raw('SUM(CASE WHEN posts.status = 1 THEN 1 ELSE 0 END) as total_duyet'),
                    DB::raw('SUM(CASE WHEN posts.status = -1 THEN 1 ELSE 0 END) as total_tuchoi')
                )
                
                ->first();
        }

        return $quantityPosts;

    }
    public function user($nam, $thang)
{
    if ($nam == 0 && $thang != 0) {
        $quantityPosts = DB::table('users')
            ->select(DB::raw('count(users.user_id) as total_user, 
                               count(DISTINCT posts.user_id) as total_user_in_posts'))
            ->leftJoin('posts', 'users.user_id', '=', 'posts.user_id')
            ->where('users.role', '0')
            ->whereMonth('users.date_create', $thang)
            ->first();
    } elseif ($thang == 0 && $nam != 0) {
        $quantityPosts = DB::table('users')
            ->select(DB::raw('count(users.user_id) as total_user, 
                               count(DISTINCT posts.user_id) as total_user_in_posts'))
            ->leftJoin('posts', 'users.user_id', '=', 'posts.user_id')
            ->whereYear('users.date_create', $nam)
            ->where('users.role', '0')
            ->first();
    } elseif ($thang != 0 && $nam != 0) {
        $quantityPosts = DB::table('users')
            ->select(DB::raw('count(users.user_id) as total_user, 
                               count(DISTINCT posts.user_id) as total_user_in_posts'))
            ->leftJoin('posts', 'users.user_id', '=', 'posts.user_id')
            ->whereYear('users.date_create', $nam)
            ->whereMonth('users.date_create', $thang)
            ->where('users.role', '0')
            ->first();
    } else {
        $quantityPosts = DB::table('users')
            ->select(DB::raw('count(users.user_id) as total_user, 
                               count(DISTINCT posts.user_id) as total_user_in_posts'))
            ->leftJoin('posts', 'users.user_id', '=', 'posts.user_id')
            ->where('users.role', '0')
            ->first();
    }
        if ($quantityPosts->total_user == 0)
            $quantityPosts->tyle = 0;
        else $quantityPosts->tyle = number_format($quantityPosts->total_user_in_posts / $quantityPosts->total_user,2);

    return $quantityPosts;
}

}