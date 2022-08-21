<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.profil.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site = DB::table('site')->select()->where('kodesite', '=', Auth::user()->kodesite)->get();
        $newSite = DB::table('site')->select('kodesite', 'namasite')->where('status', '=', 1)->orderBy('namasite')->get();
        $posisi = DB::table('mp_biodata')->select(DB::raw("distinct jabatan"))->whereNotNull('jabatan')->where('jabatan', '<>', '')->where('jabatan', '<>', '-')->orderBy('jabatan')->get();
        return view('admin.profil.edit', compact('site', 'newSite', 'posisi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'posisi' => 'required'
        ]);

        $record = User::findOrFail($id);
        
        if($request->file('foto') == ''){
            $record->update([
                'name'              => $request->name,
                'posisi'            => $request->posisi,
            ]);
        } else {
            
            Storage::disk('local')->delete('http://172.172.55.2').basename($record->foto);

            $record->update([
                'name'              => $request->name,
                'posisi'            => $request->posisi,
                'foto'            => $request->foto,
            ]);
        }


        if($record){
            return redirect()->route('admin.profil.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('admin.profil.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
