<?php

namespace App\Http\Controllers;

use App\Models\JointSurvey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JointSurveyController extends Controller
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
        $data = collect(DB::select(DB::raw("Select id, tgl, (select namasite from site where kodesite=pma_joint_survey.kodesite), pit, ob, coal, dist from pma_joint_survey order by id desc limit 15")));
        $site = DB::table('site')->select('kodesite', 'namasite')->where('kodesite', '=', Auth::user()->kodesite)->get();
        $unit = DB::table('plant_hm')->select('nom_unit')->where('kodesite', '=', Auth::user()->kodesite)->orderBy('nom_unit')->get();
        $waktu = Carbon::now()->format('Y-m-d');
        $pit = Auth::user()->kodesite === 'X' ? DB::table('pma_dailyprod_pit')->select('ket')->get() : DB::table('pma_dailyprod_pit')->select('ket')->where('kodesite', '=', Auth::user()->kodesite)->get();
        
        return view('joint-survey.create', compact('site', 'unit', 'waktu', 'data', 'pit'));
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
            'pit' => 'required',
            'tgl' => 'required',
            'ob' => 'required',
            'coal' => 'required',
            'dist' => 'required',
        ]);

        $record = JointSurvey::create([
            'tgl' => $request->tgl,
            'kodesite' => Auth::user()->kodesite,
            'pit' => $request->pit,
            'ob' => $request->ob,
            'coal' => $request->coal,                                                                                                                                                                                                                                                 
            'dist' => $request->dist,
            'bulan' => Carbon::createFromDate($request->tgl)->format('m'),
            'tahun' => Carbon::createFromDate($request->tgl)->format('Y'),
        ]);

        if($record){
            return redirect()->route('joint-survey.create')->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('joint-survey.create')->with(['error' => 'Data Gagal Ditambah!']);
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
        //
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
        //
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
