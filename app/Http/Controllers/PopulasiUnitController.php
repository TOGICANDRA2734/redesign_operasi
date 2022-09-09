<?php

namespace App\Http\Controllers;

use App\Models\Plant_Populasi;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopulasiUnitController extends Controller
{
    public function index()
    {
        $data = DB::table('plant_populasi')
        ->select(DB::raw("plant_populasi.id, plant_populasi.nom_unit, site.namasite, DATE_FORMAT(do, '%d-%m-%Y'), model, type_unit, sn, engine_brand, engine_model, engine_sn, hp, fuel,  HM, KM"))
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
        ->get();
        // ->paginate(request()->paginate ? request()->paginate : 50)
        // ->withQueryString();

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
        return view('data-prod.show');
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
