<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\loaiphong;
class loaiphongController extends Controller
{
    public function index(){
        $phong =  loaiphong::all();
        // dd($loai);
        return view('admin.loaiphong.loaiphong',[
            'loai'  => $phong,
        ]);
    }
    public function create(){
        // $phong =  loai::all();
        // // dd($loai);
        return view('admin.loaiphong.create');
    }
    public function store(Request  $request){
       $loai = new Loaiphong();
       $loai->name = $request->input('name');
       $loai->save();
       return redirect('/admin/ql_loai')->with('msg', 'Thêm thành công');



    }
    public function  edit($id){
        $loai = new Loaiphong;
        $loai = $loai::find($id);
        if($loai){
            return view('admin.loaiphong.edit')->with('loai',$loai);
        }else{
           $msg_err="<script> confirm('không tồn tại nhà trọ này')</script>";
            return redirect('/admin/ql_loai')->with('msg_err',$msg_err);
        }
       
    }
    public function  update(Request  $request,$id){
        $loai = new loaiphong();
        $loai = $loai::where('id',$id)
                                ->update([
                                    'name'=>$request->input('name'),
                                    
                                ]);

        return redirect('/admin/ql_loai')->with('msg', 'Chỉnh sửa thành công');

    }
    public function destroy($id){
        $loai = new loaiphong();
        $loai = $loai::where('id',$id)->delete();
        // $loai->delete();
        // dd($id);;
        $msg = "Xóa thành công";
         return redirect()->back()->with('msg', $msg);

    
    }

}