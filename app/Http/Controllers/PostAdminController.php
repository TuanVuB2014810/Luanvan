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
use CarbonCarbon;
use Jenssegers\Date\Date;

class PostAdminController extends Controller
{
    public function duyetbaiAn(Request $request,$id){
        // dd($request->all());
        $post = new Post();
        $msg = $request->customReason ?? $request->reason;
        $post = $post::where('maphong', $id)
            ->update([
                'status' => -1,
                'errMess' => $msg,
            ]);
        return redirect('/admin/ql_dangbai')->with('msg_duyet', 'Duyệt bài thành công');
    }
    public function duyetbai($id)
    {
        $post = new Post();
        $post = $post::where('maphong', $id)
            ->update([
                'status' => 1,
            ]);
        return redirect('/admin/ql_dangbai')->with('msg_duyet', 'Duyệt bài thành công');
    }
}