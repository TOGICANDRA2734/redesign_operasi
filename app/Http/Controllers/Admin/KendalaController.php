<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendala;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KendalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $bulan = Carbon::now();
        $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";
        $tanggalKedua =  "A.TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";

        /**
         * Kendala
         */
        $subquery = "SELECT *
        FROM pma_dailyprod_kendala
        WHERE tgl=CURDATE() AND
        kodesite='".Auth::user()->kodesite."'";

        $kendala = collect(DB::select($subquery));

        $site = DB::table('site')->select('namasite')->where('kodesite', '=', Auth::user()->kodesite)->get();

        return view('kendala.index', compact('kendala', 'site'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $site = DB::table('site')->select('kodesite', 'namasite')->where('kodesite', '=', Auth::user()->kodesite)->get();
        $unit = DB::table('plant_hm')->select('nom_unit')->where('kodesite', '=', Auth::user()->kodesite)->orderBy('nom_unit')->get();
        return view('kendala.create', compact('site', 'unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl' => 'required',
            'unit' => 'required',
            'shift' => 'required',
            'awal' => 'required',
            'akhir' => 'required',
            'ket' => 'required',
            'kodesite' => 'required',
        ]);

        $record = Kendala::create([
            'tgl' => $request->tgl,
            'unit' => $request->unit,
            'shift' => $request->shift,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'ket' => strtoupper($request->ket),
            'kodesite' => $request->kodesite,
        ]);

        if($record){
            return redirect()->route('kendala.index')->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('kendala.index')->with(['error' => 'Data Gagal Ditambah!']);
        }
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
        $data = Kendala::findOrFail($id);
        $site = DB::table('site')->select('kodesite', 'namasite')->where('kodesite', '=', Auth::user()->kodesite)->get();
        $unit = DB::table('plant_hm')->select('nom_unit')->where('kodesite', '=', Auth::user()->kodesite)->orderBy('nom_unit')->get();
        return view('kendala.edit', compact('data','site', 'unit'));
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
            'tgl' => 'required',
            'unit' => 'required',
            'shift' => 'required',
            'awal' => 'required',
            'akhir' => 'required',
            'ket' => 'required',
            'kodesite' => 'required',
        ]);

        $record = Kendala::findOrFail($id);

        $record->update([
            'tgl' => $request->tgl,
            'unit' => $request->unit,
            'shift' => $request->shift,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'ket' => strtoupper($request->ket),
            'kodesite' => $request->kodesite,
        ]);

        if($record){
            return redirect()->route('kendala.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('kendala.index')->with(['error' => 'Data Gagal Diupdate!']);
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
