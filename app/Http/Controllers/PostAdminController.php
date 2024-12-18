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
    public function duyetbaiAn(Request $request, $id) {
        $post = new Post();
        $msg = $request->customReason ?? $request->reason;
        $post = $post::where('maphong', $id)
            ->update([
                'status' => -1,
                'errMess' => $msg,
            ]);
    
        // Trả về phản hồi JSON
        return response()->json(['msg' => 'Duyệt bài thành công']);
    }
    

    public function duyetbai(Request $request)
    {
        $id = $request->input('id');
    
        // Tìm bài viết theo ID
        $post = Post::where('maphong', $id)->first();
    
        // Kiểm tra xem bài viết có tồn tại không
        if ($post) {
            // Cập nhật trạng thái bài viết
            $post->status = 1;
            $post->save();
    
            // Trả về phản hồi với thông tin bài viết
            return response()->json([
                'success' => true,
                'message' => 'Duyệt bài thành công',
                'status' => $post->status // Trả về trạng thái mới
            ]);
        }
    
        return response()->json(['success' => false, 'message' => 'Không tìm thấy bài viết']);
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
    public function  destroy($id)
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
        $post->status = 1;

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
        return redirect('/admin/ql_dangbai')->with('msg', 'Thêm thành công');
    }
    public function showCreateForm()
    {
        $loai = Loaiphong::all();
    
        return view('admin.post.createPost')->with('loai', $loai);
    }
}