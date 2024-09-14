<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Carbon\Carbon;
class LoginFacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
           
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
            $nowInVietnam = Carbon::now();
            $date_create=$nowInVietnam;
            $user = Socialite::driver('facebook')->user();
           
            $finduser = User::where('facebook_id', $user->id)->first();
         
            if($finduser){
         
                Auth::login($finduser);
       
                return redirect()->intended('/');
         
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'name' => $user->name,
                        'facebook_id'=> $user->id,
                        'avt'=>'nen.png',
                        'password' => encrypt('123456dummy'),
                        'date_create' => $date_create,
                    ]);
        
                Auth::login($newUser);
        
                return redirect()->intended('/');
            }
       
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}