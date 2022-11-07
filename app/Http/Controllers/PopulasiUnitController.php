<?php

namespace App\Http\Controllers;

use App\Models\dataProd;
use App\Models\Plant_Populasi;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PopulasiUnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->cariNama !== null && $request->kodesite !== null) {
            $nama =  "AND a.NOM_UNIT LIKE \"%" . $request->cariNama . "%\"";
        } else if ($request->has('cariNama') && $request->cariNama !== null) {
            $nama =  "WHERE a.NOM_UNIT LIKE \"%" . $request->cariNama . "%\"";
        } else {
            $nama = "";
        }

        if ($request->pilihModel && $request->pilihModel != '') {
            $model =  "AND a.model LIKE \"%" . $request->pilihModel . "%\"";
        } else {
            $model = "";
        }

        // dd($model);

        if ($request->has('kodesite') && $request->kodesite !== 'all') {
            $subquery = "SELECT a.id id, a.nom_unit nom_unit, c.namasite namasite, DATE_FORMAT(do, '%d-%m-%Y') DO, model, type_unit, sn, engine_brand, engine_model, engine_sn, hp, fuel,  HM, KM
                FROM plant_populasi a
                JOIN plant_HM b
                ON  a.nom_unit=b.nom_unit
                JOIN site c
                ON b.kodesite = c.kodesite
                WHERE b.kodesite='" . $request->kodesite . "' " . $nama . " " . $model . "";
        } else {
            $subquery = "SELECT a.id id, a.nom_unit nom_unit, c.namasite namasite, DATE_FORMAT(do, '%d-%m-%Y') DO, model, type_unit, sn, engine_brand, engine_model, engine_sn, hp, fuel,  (SELECT HM FROM PLANT_HM WHERE NOM_UNIT=A.NOM_UNIT ORDER BY TGL DESC LIMIT 1) HM, (SELECT KM FROM PLANT_HM WHERE NOM_UNIT=A.NOM_UNIT ORDER BY TGL DESC LIMIT 1) KM
                FROM plant_populasi a
                JOIN plant_HM b
                ON  a.nom_unit=b.nom_unit
                JOIN site c
                ON b.kodesite = c.kodesite
                " . $nama . " " . $model . "";
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
            ->when(request()->site, function ($data) {
                $data = $data->where('plant_hm.kodesite', '=', request()->site);
            })
            ->when(request()->jenisTipe, function ($data) {
                $data = $data->where('plant_populasi.type_unit', '=', request()->jenisTipe);
            })
            ->when(request()->nama, function ($data) {
                $data = $data->where('plant_populasi.nom_unit', 'like', '%' . request()->nama . '%');
            })
            ->groupBy('plant_populasi.type_unit')
            ->groupBy('plant_hm.tgl')
            ->get();

        if ($request->has('kodesite') || $request->has('cariNama')) {
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
        $status = Auth::user()->kodesite === "X" ? 1 : 0;
        $subquery = "SELECT DISTINCT model FROM plant_populasi";
        $model = collect(DB::select($subquery));

        $site = $status ? Site::where('status', 1)->get() : Site::where('kodesite', Auth::user()->kodesite)->get();

        $subquery = "SELECT DISTINCT type_unit FROM plant_populasi";
        $type_unit = collect(DB::select($subquery));

        $subquery = "SELECT DISTINCT engine_brand FROM plant_populasi";
        $engine_brand = collect(DB::select($subquery));

        $subquery = "SELECT DISTINCT engine_model FROM plant_populasi";
        $engine_model = collect(DB::select($subquery));

        $subquery = "SELECT * FROM PLANT_POPULASI_BAGIAN WHERE del=0";
        $status_bagian = collect(DB::select(DB::raw($subquery)));

        return view('populasi-unit.create', compact('site', 'model', 'type_unit', 'engine_brand', 'engine_model', 'status_bagian'));
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
            'nom_unit' => 'required|max:10|unique:plant_populasi,nom_unit',
            'model' => 'required',
            'type_unit' => 'required',
            'sn' => 'required',
            'engine_brand' => 'required',
            'engine_model' => 'required',
            'engine_sn' => 'required',
            // 'generator_brand' => 'required',
            // 'generator_model' => 'required',
            // 'generator_sn' => 'required',
            // 'pump_merk' => 'required',
            // 'pump_model' => 'required',
            // 'pump_sn' => 'required',
            // 'comp_merk' => 'required',
            // 'comp_model' => 'required',
            // 'comp_sn' => 'required',
            // 'kapasitas' => 'required',
            'HP' => 'required',
            'do' => 'required',
            // 'pic_1' => 'required',
            // 'pic_2' => 'required',
            // 'height' => 'required',
            // 'width' => 'required',
            // 'length' => 'required',
            // 'fuel' => 'required',
            'status_bagian' => 'required',
            'status_kepemilikan' => 'required',
            'kodesite' => 'required',
        ]);

        $record = Plant_Populasi::create([
            'nom_unit' => $request->nom_unit,
            'model' => $request->model,
            'type_unit' => $request->type_unit,
            'sn' => $request->sn,
            'engine_brand' => $request->engine_brand,
            'engine_model' => $request->engine_model,
            'engine_sn' => $request->engine_sn,
            'generator_brand' => $request->generator_brand,
            'generator_model' => $request->generator_model,
            'generator_sn' => $request->generator_sn,
            'pump_merk' => $request->pump_merk,
            'pump_model' => $request->pump_model,
            'pump_sn' => $request->pump_sn,
            'comp_merk' => $request->comp_merk,
            'comp_model' => $request->comp_model,
            'comp_sn' => $request->comp_sn,
            'kapasitas' => $request->kapasitas,
            'HP' => $request->HP,
            'DO' => $request->do,
            'pic_1' => $request->pic_1,
            'pic_2' => $request->pic_2,
            'height' => $request->height,
            'width' => $request->width,
            'length' => $request->length,
            'fuel' => $request->fuel,
            'status_bagian' => $request->status_bagian,
            'status_kepemilikan' => $request->status_kepemilikan,
            'kodesite' => $request->kodesite,
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
        $data = DB::table('plant_populasi')->where('id', '=', $id)->get();
        $dataHM = DB::table('plant_hm')->select(DB::raw('id, nom_unit, DATE_FORMAT(TGL, "%d-%m-%Y") tgl, hm'))->where('nom_unit', $data[0]->nom_unit)->get();

        return view('populasi-unit.show', compact('data', 'dataHM'));
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

        $site = Site::all();

        $subquery = "SELECT DISTINCT type_unit FROM plant_populasi";
        $type_unit = collect(DB::select($subquery));

        $subquery = "SELECT DISTINCT engine_brand FROM plant_populasi";
        $engine_brand = collect(DB::select($subquery));

        $subquery = "SELECT DISTINCT engine_model FROM plant_populasi";
        $engine_model = collect(DB::select($subquery));

        $subquery = "SELECT * FROM PLANT_POPULASI_BAGIAN WHERE del=0";
        $status_bagian = collect(DB::select(DB::raw($subquery)));

        $data = Plant_Populasi::findOrFail($id);

        return view('populasi-unit.edit', compact('site', 'model', 'type_unit', 'engine_brand', 'engine_model', 'status_bagian', 'data'));
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
            'model' => 'required',
            'type_unit' => 'required',
            'sn' => 'required',
            'engine_brand' => 'required',
            'engine_model' => 'required',
            'engine_sn' => 'required',
            // 'generator_brand' => 'required',
            // 'generator_model' => 'required',
            // 'generator_sn' => 'required',
            // 'pump_merk' => 'required',
            // 'pump_model' => 'required',
            // 'pump_sn' => 'required',
            // 'comp_merk' => 'required',
            // 'comp_model' => 'required',
            // 'comp_sn' => 'required',
            // 'kapasitas' => 'required',
            'HP' => 'required',
            'do' => 'required',
            // 'pic_1' => 'required',
            // 'pic_2' => 'required',
            // 'height' => 'required',
            // 'width' => 'required',
            // 'length' => 'required',
            // 'fuel' => 'required',
            'status_bagian' => 'required',
            'status_kepemilikan' => 'required',
            'kodesite' => 'required',
        ]);

        $record = Plant_Populasi::findOrFail($id);

        $record->update([
            'nom_unit'                  => $request->nom_unit,
            'model'                     => $request->model,
            'type_unit'                 => $request->type_unit,
            'sn'                        => $request->sn,
            'engine_brand'              => $request->engine_brand,
            'engine_model'              => $request->engine_model,
            'engine_sn'                 => $request->engine_sn,
            'generator_brand'           => $request->generator_brand,
            'generator_model'           => $request->generator_model,
            'generator_sn'              => $request->generator_sn,
            'pump_merk'                 => $request->pump_merk,
            'pump_model'                => $request->pump_model,
            'pump_sn'                   => $request->pump_sn,
            'comp_merk'                 => $request->comp_merk,
            'comp_model'                => $request->comp_model,
            'comp_sn'                   => $request->comp_sn,
            'kapasitas'                 => $request->kapasitas,
            'HP'                        => $request->HP,
            'DO'                        => $request->do,
            'pic_1'                     => $request->pic_1,
            'pic_2'                     => $request->pic_2,
            'height'                    => $request->height,
            'width'                     => $request->width,
            'length'                    => $request->length,
            'fuel'                      => $request->fuel,
            'status_bagian'             => $request->status_bagian,
            'status_kepemilikan'        => $request->status_kepemilikan,
            'kodesite'                  => $request->kodesite,
        ]);

        if ($record) {
            return redirect()->route('populasi-unit.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('populasi-unit.edit', $request->id)->with(['error' => 'Data Gagal Diupdate!']);
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

    public function getUserbyid(Request $request){
    
        $userid = $request->userid;

        $subquery = "SELECT  * FROM plant_populasi WHERE id=". $userid;

        $data = collect(DB::select($subquery));

        $response['data'] = $data;
        
        return response()->json($response);
    }

    public function delete($id)
    {
        $record = Plant_Populasi::findOrFail($id);
        
        $record->update([
            'del' => 0,
        ]);

        
        if ($record) {
            return redirect()->route('populasi-unit.index')->with(['success' => 'Data Berhasil dihapus!']);
        } else {
            return redirect()->route('populasi-unit.index')->with(['error' => 'Data Gagal dihapus!']);
        }
    }
}
