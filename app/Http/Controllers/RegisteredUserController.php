<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

use function PHPUnit\Framework\isNull;

class RegisteredUserController extends Controller
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
            'username' => 'required|string|max:15|unique:user',
            'name' => 'required|string|max:50',
            'posisi' => 'required|string|max:50',
            'foto' => 'max:2000',
            'kodesite' => 'required|string|max:1',
            'role' => 'required',
            'password' => 'required',
        ]);
        
        // Store image
        if(!isNull($request->foto)){
            $foto = $request->file('foto');
            $foto->storeAs('public/images', $foto->hashName());    

            $user =  User::create([
                'username' => $request->username,
                'nama' => $request->name,
                'posisi' => $request->posisi,
                'foto' => $foto->hashName(),
                'kodesite' => $request->kodesite,
                'password' => md5($request->password),
            ]);    
        } else {
            $user =  User::create([
                'username' => $request->username,
                'nama' => $request->name,
                'posisi' => $request->posisi,
                'kodesite' => $request->kodesite,
                'password' => md5($request->password),
            ]);
        }

        $user->assignRole($request->role);

        if($user){
            return redirect()->route('profil.edit', Auth::user()->id)->with(['success' => 'Data pengguna berhasil ditambahkan!']);
        }
        else{
            return redirect()->route('profil.index', Auth::user()->id)->with(['error' => 'Data pengguna gagal ditambahkan!']);
        }
    }
}