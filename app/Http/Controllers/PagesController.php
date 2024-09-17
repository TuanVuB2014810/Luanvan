<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
class PagesController extends Controller
{
    public function index(){
        $post = new post();
        $post = DB::table('phongtro')
        ->join('posts', 'phongtro.maphong', '=', 'posts.maphong')
        ->select('phongtro.*', 'posts.*')
        ->get();
        // dd($post->all());
        return view('user.index')->with('post',$post);
    }
    public function about(){
        $name = 'vu';
        $names =array('tran','tuan','vu');
        return view('user.about',['names'=>$names,], compact('name'));
    }
    public function phongtro(){
        return view('Phongtro.phongtro');
    }
}
