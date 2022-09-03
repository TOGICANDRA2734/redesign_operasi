<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopulasiUnitController extends Controller
{
    public function index()
    {
        $data = DB::table('plant_populasi')
        ->select(DB::raw("plant_populasi.id, plant_populasi.nom_unit, model, type_unit, sn, engine_brand, engine_model, engine_sn, hp, fuel,  KM, site.namasite"))
        ->join('plant_hm', 'plant_populasi.nom_unit', '=', 'plant_hm.nom_unit')
        ->join('site', 'plant_hm.kodesite', '=', 'site.kodesite')
        ->when(request()->site, function($data){
            $data = $data->where('plant_hm.kodesite', '=', request()->site);
        })
        ->when(request()->jenisTipe, function($data){
            $data = $data->where('plant_populasi.type_unit', '=', request()->jenisTipe);
        })
        ->when(request()->jenisBrand, function($data){
            $data = $data->where('plant_populasi.engine_brand', '=', request()->jenisBrand);
        })
        ->when(request()->nama, function($data){
            $data = $data->where('plant_populasi.nom_unit', 'like', '%'.request()->nama.'%');
        })   
        ->paginate(request()->paginate ? request()->paginate : 50)
        ->withQueryString();

        // dd($data);

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

        $jenisTipe = collect(DB::select(
            DB::raw("
                SELECT 
                DISTINCT type_unit
                FROM plant_populasi
            ")
        ));

        $jenisBrand = collect(DB::select(
            DB::raw("
                SELECT 
                DISTINCT IF(ENGINE_BRAND='','Tidak Ada Brand', engine_brand) AS brand
                FROM plant_populasi
                ORDER BY brand
            ")
        ));

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


        return view('populasi-unit.index', compact('data', 'site', 'jenisTipe', 'jenisBrand', 'summary'));
    }

    public function getUserbyid(Request $request){

        $userid = $request->userid;

        $data = DB::table('plant_populasi')->select('*')->join('plant_hm', 'plant_populasi.nom_unit', '=', 'plant_hm.nom_unit')->where('plant_hm.id', $userid)->get();

        $dataChart = DB::table('pma_a2b')->select(DB::raw("
            MONTHNAME(TGL),
            (SUM(jam)-SUM(IF(LEFT(kode,1)='B',jam,0)))/SUM(jam) AS MA
        "))
        ->where('nom_unit', '=', $data[0]->nom_unit)
        ->get();
        
        
        if(!isset($dataChart)){
            $dataChart = DB::table('pmatp')->select(DB::raw("
                MONTHNAME(TGL),
                (SUM(jam)-SUM(IF(LEFT(aktivitas,1)='B',jam,0)))/SUM(jam) AS MA
            "))
            ->where('nom_unit', '=', $data[0]->nom_unit)
            ->get();
        }


        $response['data'] = $data;
        $response['dataChart'] = $dataChart;
        
        return response()->json($response);
    }
}
