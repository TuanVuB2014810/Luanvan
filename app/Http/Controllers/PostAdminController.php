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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
    public function import(Request $request)
    {
        // Kiểm tra xem tệp đã được tải lên chưa
        if ($request->hasFile('file')) {
            // Lấy đường dẫn tạm thời của tệp
            $path = $request->file('file')->getRealPath();

            // Đọc dữ liệu từ tệp Excel
            $spreadsheet = IOFactory::load($path);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            // Bỏ qua dòng tiêu đề
            unset($sheetData[0]);

            // Lặp qua từng dòng dữ liệu từ tệp Excel
            foreach ($sheetData as $data) {
                // Mã hóa mật khẩu bằng HASH
                // $hashedPassword = bcrypt($data[2]);

                // Lưu dữ liệu vào cơ sở dữ liệu hoặc thực hiện các xử lý khác
                    // $phongtro = new Phongtro();
                    // $phongtro->name = $data[1];
                    // $phongtro->maphong = $data[2];
                    // $phongtro->sophong = $data[9];
                    // $phongtro->gia = $data[4];
                    // $phongtro->gia_dien = $data[10];
                    // $phongtro->gia_nuoc = $data[11];
                    // $phongtro->loai_phong = $data[12];
                    // $phongtro->dia_chi = $data[6];
                    // $phongtro->huyen = $data[7];
                    // $phongtro->tinh = $data[8];
                    // $phongtro->mota = $data[5];
                    // $phongtro->dientich = $data[13];
                    // $phongtro->save();
                    
                    // $post = new Post();
                    // $post->content = $data[3];
                    // $post->user_id = $data[0];
                    // $post->maphong = $data[2];
                    // $post->date_create = now();
                    // $post->date_update = now();
                    // $post->save();
                    $post = new Image();
                    $post->phongtro_id = $data[16];
                    $post->image = $data[14];
                    $post->save();
                }

            return redirect()->back()->with('yes', 'Import thành công');
        } else {
            
            return redirect()->back()->with('no', 'Import thất bại');;
        }
    }
}