<?php

namespace App\Http\Controllers;

use App\Models\dataProd;
use App\Models\Plant_Populasi;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopulasiUnitController extends Controller
{
    public function index(Request $request)
    {
        if($request->cariNama!==null && $request->kodesite !==null){
            $nama =  "AND a.NOM_UNIT LIKE \"%".$request->cariNama."%\"";
        }
        else if($request->has('cariNama') && $request->cariNama !== null){
            $nama =  "WHERE a.NOM_UNIT LIKE \"%".$request->cariNama."%\"";
        } else {
            $nama = "";
        }

        if($request->pilihModel && $request->pilihModel !=''){
            $model =  "AND a.model LIKE \"%".$request->pilihModel."%\"";
        }
        else {
            $model = "";
        }

        // dd($model);

        if($request->has('kodesite') && $request->kodesite !== 'all'){
            $subquery = "SELECT a.id id, a.nom_unit nom_unit, c.namasite namasite, DATE_FORMAT(do, '%d-%m-%Y') DO, model, type_unit, sn, engine_brand, engine_model, engine_sn, hp, fuel,  HM, KM
            FROM plant_populasi a
            JOIN plant_HM b
            ON  a.nom_unit=b.nom_unit
            JOIN site c
            ON b.kodesite = c.kodesite
            WHERE b.kodesite='".$request->kodesite."' ".$nama." ".$model."";
        } else {
            $subquery = "SELECT a.id id, a.nom_unit nom_unit, c.namasite namasite, DATE_FORMAT(do, '%d-%m-%Y') DO, model, type_unit, sn, engine_brand, engine_model, engine_sn, hp, fuel,  HM, KM
            FROM plant_populasi a
            JOIN plant_HM b
            ON  a.nom_unit=b.nom_unit
            JOIN site c
            ON b.kodesite = c.kodesite
            ".$nama." ".$model."";
        }

        $data = collect(DB::select($subquery));

        $site = collect(DB::select(
            DB::raw("
                SELECT 
                DISTINCT B.namasite, B.kodesite, B.lokasi
                FROM plant_hm A
                JOIN (SELECT kodesite, namasite, lokasi FROM site) B
                ON A.kodesite = B.kodesite
                ORDER BY namasite
            ")
        ));

        $subquery = "SELECT DISTINCT model FROM plant_populasi WHERE del=0";
        $model = collect(DB::select($subquery));

        $summary = DB::table('plant_populasi')->select(DB::raw('DISTINCT plant_populasi.type_unit, COUNT(plant_populasi.type_unit) TOTAL'))
        ->join('plant_hm', 'plant_populasi.nom_unit', '=', 'plant_hm.nom_unit')
        ->when(request()->site, function($data){
            $data = $data->where('plant_hm.kodesite', '=', request()->site);
        })
        ->when(request()->jenisTipe, function($data){
            $data = $data->where('plant_populasi.type_unit', '=', request()->jenisTipe);
        })
        ->when(request()->nama, function($data){
            $data = $data->where('plant_populasi.nom_unit', 'like', '%'.request()->nama.'%');
        })   
        ->groupBy('plant_populasi.type_unit')
        ->groupBy('plant_hm.tgl')
        ->get();

        if($request->has('kodesite') || $request->has('cariNama')){
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('populasi-unit.index', compact('data', 'site', 'summary', 'model'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subquery = "SELECT DISTINCT model FROM plant_populasi";
        $model = collect(DB::select($subquery));

        $site = Site::where('status', 1)->get();

        $type_unit = "SELECT DISTINCT type_unit FROM plant_populasi";
        $type_unit = collect(DB::select($subquery));

        $engine_brand = "SELECT DISTINCT engine_brand FROM plant_populasi";
        $engine_brand = collect(DB::select($subquery));

        $engine_model = "SELECT DISTINCT engine_model FROM plant_populasi";
        $engine_model = collect(DB::select($subquery));

        return view('populasi-unit.create', compact('site', 'model', 'type_unit', 'engine_brand', 'engine_model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subquery = "SELECT DISTINCT model FROM plant_populasi";
        $model = collect(DB::select($subquery));

        $site = Site::where('status', 1)->get();

        $type_unit = "SELECT DISTINCT type_unit FROM plant_populasi";
        $type_unit = collect(DB::select($subquery));

        $engine_brand = "SELECT DISTINCT engine_brand FROM plant_populasi";
        $engine_brand = collect(DB::select($subquery));

        $engine_model = "SELECT DISTINCT engine_model FROM plant_populasi";
        $engine_model = collect(DB::select($subquery));

        return view('populasi-unit.edit', compact('site', 'model', 'type_unit', 'engine_brand', 'engine_model'));        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('plant_populasi')->where('id', '=', $id)->get();

        return view('populasi-unit.show', compact('data'));
    }



    public function getUserbyid(Request $request){

        $userid = $request->userid;

        $subquery = "SELECT  * FROM plant_populasi WHERE id=". $userid;

        $data = collect(DB::select($subquery));

        $response['data'] = $data;
        
        return response()->json($response);
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
            'pit' => 'required',
            'ob' => 'required',
            'coal' => 'required',
            'kodesite' => 'required',
            'cuaca' => 'required',
        ]);

        $record = dataProd::findOrFail($id);
        
        $record->update([
            'tgl'           => $request->tgl,
            'pit'           => $request->pit,
            'ob'            => $request->ob,
            'coal'          => $request->coal,
            'kodesite'      => $request->kodesite,
            'cuaca'         => $request->cuaca,
        ]);

        if($record){
            return redirect()->route('data-prod.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('data-prod.index')->with(['error' => 'Data Gagal Diupdate!']);
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
