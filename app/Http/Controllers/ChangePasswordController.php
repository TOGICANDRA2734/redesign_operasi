<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class ChangePasswordController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {       
        $this->validate($request,[
            'username' => 'required|string|max:15|unique:pma_dailyprod_users',
            'name' => 'required|string|max:50',
            'posisi' => 'required|string|max:50',
            'foto' => 'required|max:2000',
            'kodesite' => 'required|string|max:1',
            'password' => ['required', Rules\Password::defaults()],
        ]);
        
        // Store image
        $foto = $request->file('foto');
        $foto->storeAs('public/images', $foto->hashName());

        // dd($foto);

        $user =  User::create([
            'username' => $request->username,
            'name' => $request->name,
            'posisi' => $request->posisi,
            'foto' => $foto->hashName(),
            'kodesite' => $request->kodesite,
            'password' => md5($request->password),
        ]);

        if($user){
            return redirect()->route('profil.edit', Auth::user()->id)->with(['success' => 'Data pengguna berhasil ditambahkan!']);
        }
        else{
            return redirect()->route('profil.index', Auth::user()->id)->with(['error' => 'Data pengguna gagal ditambahkan!']);
        }
    }

    public function update(Request $request)
    {

        dd($request);
        $this->validate($request,[
            'password' => ['required', Rules\Password::defaults()],
            'new_password' => ['required', Rules\Password::defaults()],
        ]);

        if(md5($request->password) == Auth::user()->password){
            $user = User::findOrFail(Auth::user()->id);
            

            $user->update([
                'password' => md5($request->new_password)
            ]);

            if($user){
                return redirect()->route('profil.edit', Auth::user()->id)->with(['success' => 'Password berhasil diganti!']);
            } else {
                return redirect()->route('profil.edit', Auth::user()->id)->with(['error' => 'Password gagal diganti!']);
            }
        } else {
            return redirect()->route('profil.edit', Auth::user()->id)->with(['error' => 'Password salah!']);
        }
    }
}