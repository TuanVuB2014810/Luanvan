<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use app\Models\User;
use Illuminate\Support\Facades\View;
class AvatarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $avatarUrl = null;
        $user = Auth::user();
       
        if ($user) {
            $avatarUrl = User::find($user->user_id)->avt;
        }
        
        View::share('avatarUrl', $avatarUrl);
        return $next($request);
    }
}
