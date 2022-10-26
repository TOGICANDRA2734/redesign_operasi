<?php

namespace App\Http\Controllers;

use App\Models\Plant_Populasi;
use App\Models\PlantHM;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

class HMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $waktu = Carbon::now();
        $site = Site::select('*')->get();
        $data = PlantHM::select(DB::raw('nom_unit, date_format(tgl, "%d-%m-%Y") tgl, hm, km, kodesite'))->where('del', 0)->orderBy('tgl', 'desc')->get();
        if(strtolower(Auth::user()->kodesite) === 'x'){
            $nom_unit = Plant_Populasi::select('nom_unit')->get();
        } else {
            $nom_unit = Plant_Populasi::select('nom_unit')->where('kodesite', Auth::user()->kodesite)->get();
        }
        return view('hm.create', compact('waktu', 'site', 'data', 'nom_unit'));
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
            'nom_unit' => 'required',
            'kodesite' => 'required|max:1',
            'tgl' => 'required|date',
            'hm' => 'required|numeric',
            'km' => 'required|numeric',
        ]);

        $record = PlantHM::create([
            'nom_unit' => $request->nom_unit,
            'kodesite' => $request->kodesite,
            'tgl' => $request->tgl,
            'hm' => $request->hm,
            'km' => $request->km,
        ]);

        if($record){
            return redirect()->back()->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->back()->with(['error' => 'Data Gagal Ditambah!']);
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
        $waktu = Carbon::now();
        $site = Site::select('*')->get();
        $data = PlantHM::select(DB::raw('nom_unit, date_format(tgl, "%d-%m-%Y") tgl, hm, km, kodesite'))->where('nom_unit', Plant_Populasi::select('nom_unit')->where('id', $id)->pluck('nom_unit'))->where('del', 0)->orderBy('tgl', 'desc')->get();
        if(strtolower(Auth::user()->kodesite) === 'x'){
            $nom_unit = Plant_Populasi::select('nom_unit')->get();
        } else {
            $nom_unit = Plant_Populasi::select('nom_unit')->where('kodesite', Auth::user()->kodesite)->get();
        }
        return view('hm.edit', compact('waktu', 'site', 'data', 'nom_unit'));
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

    public function edit_data($id)
    {
        $dataEdit = PlantHM::findOrFail($id);
        $waktu = Carbon::now();
        $site = Site::select('*')->get();
        $data = PlantHM::select(DB::raw('nom_unit, date_format(tgl, "%d-%m-%Y") tgl, hm, km, kodesite'))->where('nom_unit', $dataEdit->nom_unit)->get();
        $nom_unit = strtolower(Auth::user()->kodesite) === 'x' ? Plant_Populasi::select('nom_unit')->get() : Plant_Populasi::select('nom_unit')->where('kodesite', Auth::user()->kodesite)->get() ;
        return view('hm.edit_data', compact('waktu', 'site', 'data', 'nom_unit', 'dataEdit', 'id'));
    }

    
    public function update_data(Request $request, $id)
    {
        $request->validate([
            'nom_unit' => 'required',
            'kodesite' => 'required|max:1',
            'tgl' => 'required|date',
            'hm' => 'required|numeric',
            'km' => 'required|numeric',
        ]);

        $record = PlantHM::findOrFail($id);

        $record->update([
            'nom_unit' => $request->nom_unit,
            'kodesite' => $request->kodesite,
            'tgl' => $request->tgl,
            'hm' => $request->hm,
            'km' => $request->km,
        ]);

        if($record){
            return redirect()->back()->with(['success' => 'Data Berhasil Di Update!']);
        }
        else{
            return redirect()->back()->with(['error' => 'Data Gagal Di Update!']);
        }
    }
}
