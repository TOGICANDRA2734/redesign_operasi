<?php

namespace App\Http\Controllers;

use App\Http\Request\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginView()
    {
        return view('login.main', [
            'layout' => 'login'
        ]);
    }

    /**
     * Authenticate login user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->get('username'))->where('password', md5($request->password))->first();


        if (!$user) {
            throw new \Exception('Username dan/atau password salah.');
        }
        else {
            if($user->hasRole('admin')){
                Auth::login($user, $request->remember_me);
                return 'admin';
            } else if($user->hasRole('user')){
                Auth::login($user, $request->remember_me);
                return 'user';
            } else if($user->hasRole('super_admin')){
                Auth::login($user, $request->remember_me);
                return 'super_admin';
            }
        }
    }

    /**
     * Logout user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
