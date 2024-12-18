<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\evaluate;
use App\Models\User;
use Illuminate\Support\Facades\DB; 
class DanhgiaController extends Controller
{
    public function index(){
        $phong = DB::table('users')
            ->join('evaluates', 'users.user_id', '=', 'evaluates.user_id')
            ->select('users.name', 'evaluates.id','evaluates.rating', 'evaluates.comment')
            ->get();

        return view('admin.evaluate.evaluate',[
            'danhgia'  => $phong,
        ]);
    }
    public function destroy($id)
    {
        $deleted = evaluate::where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['success' => 'Xóa thành công']);
        }

        return response()->json(['error' => 'Xóa thất bại'], 500);
    }
}
