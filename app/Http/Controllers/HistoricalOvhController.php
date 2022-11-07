<?php

namespace App\Http\Controllers;

use App\Models\Plant_Populasi;
use App\Models\PlantOvh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalOvhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('plant_ovh')
        ->selectRaw("nom_unit, model, komponen, date_format(ovh_start, \"%d-%m-%Y\") ovh_start, date_format(ovh_end, \"%d-%m-%Y\") ovh_end, hm, remark")
        ->orderBy('nom_unit')
        ->orderBy('hm')
        ->orderBy('komponen')
        ->orderBy('ovh_start')
        ->limit(250)
        ->get();
        $subquery = "SELECT DISTINCT komponen FROM plant_ovh ORDER BY komponen";
        $komponen = collect(DB::select(DB::raw($subquery)));
        return view('historical-overhaul.index', compact('data', 'komponen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = DB::table('plant_ovh')
        ->selectRaw("nom_unit, model, komponen, date_format(ovh_start, \"%d-%m-%Y\") ovh_start, date_format(ovh_end, \"%d-%m-%Y\") ovh_end, hm, remark")
        ->orderBy('id', 'desc')
        ->limit(5)
        ->get();
        $subquery = "SELECT DISTINCT komponen FROM plant_ovh ORDER BY komponen";
        $komponen = collect(DB::select(DB::raw($subquery)));
        $nom_unit = Plant_Populasi::select('nom_unit')->where('del', 0)->get();
        $model = Plant_Populasi::select('model')->where('del', 0)->groupBy('model')->get();
        $komponen = PlantOvh::select('komponen')->where('del', 0)->groupBy('komponen')->get();
        return view('historical-overhaul.create', compact('data', 'komponen', 'nom_unit', 'model', 'komponen'));
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
            'komponen' => 'required',
            'start' => 'required|date',
            'finish' => 'date|after_or_equal:start',
            'hm' => 'required',
            'remark' => 'required',
        ]);

        $model = PlantOvh::select('model')->where('nom_unit', 'like', '%'.substr($request->nom_unit,0,4).'%')->limit(1)->get();
        $record = PlantOvh::create([
            'nom_unit' => $request->nom_unit,
            'model' => strtoupper($model[0]->model),
            'komponen' => $request->komponen,
            'ovh_start' => $request->start,
            'ovh_end' => $request->finish,
            'hm' => $request->hm,
            'remark' => $request->remark,
            'status' => 1
        ]);

        if($record){
            return redirect()->route('historical-overhaul.create')->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('historical-overhaul.create')->with(['error' => 'Data Gagal Ditambah!']);
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

    public function showFilter(Request $request)
    {
        
        $where = '';
        
        if(count($request->all()) > 1){
            $where .= "WHERE ";
            $where .= ($request->has('pilihKomponen') && !empty($request->pilihKomponen)) ? "komponen='" . $request->pilihKomponen . "'" : "";
            $where .= (!empty($request->pilihKomponen) && $request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $where .= ($request->has('cariNama') && !empty($request->cariNama)) ? "nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $where .= "AND DEL=0";    
        }
        
        $subquery = "SELECT nom_unit, model, komponen, date_format(ovh_start, \"%d-%m-%Y\") ovh_start, date_format(ovh_end, \"%d-%m-%Y\") ovh_end, hm, remark
        FROM plant_ovh
        ".$where."
        ORDER BY nom_unit, model, komponen";

        $data = collect(DB::select($subquery));

        $response['data'] = $data;
        return response()->json($response);
    }
}
