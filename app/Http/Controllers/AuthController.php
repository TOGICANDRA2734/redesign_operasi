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
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->where('password', md5($request->password))->first();

        if($user) {
            if($user->hasRole('admin')){
                Auth::login($user, $request->remember_me);
                // return to admin page
                // dd($user);

                return redirect()->route('admin.dashboard');
            } else if($user->hasRole('user')){
                Auth::login($user, $request->remember_me);
                // return to user page
                // return 'testing.user';
                return redirect()->route('user.dashboard');
            } else if($user->hasRole('super_admin')){
                Auth::login($user, $request->remember_me);
                // return to super admin page
                // return 'testing.super_admin';
                return redirect()->route('super_admin.dashboard');
            }
        } else {
            return redirect()->route('login.index')->with(['error' => 'Username dan/atau password salah!']);
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
