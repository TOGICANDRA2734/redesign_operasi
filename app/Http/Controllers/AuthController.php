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
            throw new \Exception('Wrong email or password.');
        }
        else {
            Auth::login($user, $request->remember_me);

            return redirect()->route('dashboard');
        }



        // if (!Auth::attempt([
        //     'username' => $request->username,
        //     'password' => $request->password
        // ])) {
        //     throw new \Exception('Wrong email or password.');
        // }
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
