<?php

// app/Http/Controllers/LoginGoogleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Carbon\Carbon;

class LoginGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Nhận thông tin người dùng từ Google
            $user = Socialite::driver('google')->user();

            // Tìm người dùng dựa trên Google ID
            $finduser = User::where('google_id', $user->id)->first();
            $nowInVietnam = Carbon::now();
            $date_create = $nowInVietnam;

            if ($finduser) {
                // Đăng nhập người dùng nếu đã tồn tại
                Auth::login($finduser);
                return redirect()->intended('/');
            } else {
                // Tạo người dùng mới nếu chưa tồn tại
                $newUser = User::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'google_id' => $user->id,
                        'avt' => 'nen.png',
                        'password' => bcrypt('123456dummy'),
                        'date_create' => $date_create,
                    ]
                );

                if ($newUser) {
                    Auth::login($newUser);
                    return redirect()->intended('/');
                } else {
                    throw new Exception('Failed to create new user');
                }
            }

        } catch (Exception $e) {
            // Xử lý lỗi và hiện thông báo lỗi
            dd($e->getMessage());
        }
    }
}
