<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phongtro;
use App\Models\Loaiphong;
use App\Helpers\Format;

class PhongtroController extends Controller
{
    public function index(){
        $phong =  phongtro::all();
        // dd($phongtro);
       
        // dd($phong);
        foreach ($phong as $p) {
            $p->name = Format::textShorten($p->name);
            $p->gia = Format::format_currency($p->gia);
            $p->gia_nuoc = Format::format_currency($p->gia_nuoc);
            $p->gia_dien= Format::format_currency($p->gia_dien);

        }
         return view('admin.Phongtro.Phongtro',[
            'phongtro'  => $phong,
        ]);
    }
    public function create(){
        // $phong =  phongtro::all();
        // // dd($phongtro);
        $loai = Loaiphong::all();
        return view('admin.Phongtro.create')->with('loai',$loai);
    }
    public function store(Request  $request){
       $phongtro = new Phongtro();
       $phongtro->name = $request->input('name');
       $phongtro->so_cho = $request->input('sl');
       $phongtro->gia = $request->input('gia');
       $phongtro->gia_nuoc = $request->input('gia_nuoc');
       $phongtro->gia_dien = $request->input('gia_nuoc');
       $phongtro->mota = $request->input('desc');
       $phongtro->loai_phong = $request->input('type');
       $phongtro->save();
       return redirect('/admin/ql_phongtro');


    }
    public function  edit($id){
        $phongtro = new Phongtro;
        $phongtro = $phongtro::find($id);
        if($phongtro){
            return view('admin.Phongtro.edit')->with('phongtro',$phongtro);
        }else{
           $msg_err="<script> confirm('không tồn tại nhà trọ này')</script>";
            return redirect('/admin/ql_phongtro')->with('msg_err',$msg_err);
        }
       
    }
    public function  update(Request  $request,$id){
        $phongtro = new Phongtro();
        $phongtro = $phongtro::where('phongtro_id',$id)
                                ->update([
                                    'name'=>$request->input('name'),
                                    'sophong'=>$request->input('sl'),
                                    'gia'=>$request->input('gia'),
                                    'gia_nuoc'=>$request->input('gia_nuoc'),
                                    'gia_dien'=>$request->input('gia_dien'),
                                    'mota'=>$request->input('desc'),
                                    'loai_phong'=>$request->input('type'),
                                ]);

        return redirect('/admin/ql_phongtro');
    }
    public function destroy($id){
        $phongtro = new Phongtro();
        $phongtro = $phongtro::where('phongtro_id',$id)->delete();
        // $phongtro->delete();
        // // dd($id);;
        return redirect('/admin/ql_phongtro');
    
    }
    

}