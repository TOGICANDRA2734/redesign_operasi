<?php

namespace App\Http\Controllers;

use App\Models\Plant_bd;
use App\Models\Plant_Populasi;
use App\Models\PlantOvh;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BDHarianController extends Controller
{
    private $idTable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        // if($request->has('kodesite') && $request->kodesite !== 'all'){
        //     $subquery = "SELECT a.id id, a.nom_unit nom_unit, c.namasite namasite, DATE_FORMAT(do, '%d-%m-%Y') DO, model, type_unit, sn, engine_brand, engine_model, engine_sn, hp, fuel,  HM, KM
        //     FROM plant_populasi a
        //     JOIN plant_HM b
        //     ON  a.nom_unit=b.nom_unit
        //     JOIN site c
        //     ON b.kodesite = c.kodesite
        //     WHERE b.kodesite='".$request->kodesite."' ".$nama."";
        // } else {
        //     $subquery = "SELECT a.id id, a.nom_unit nom_unit, c.namasite namasite, DATE_FORMAT(do, '%d-%m-%Y') DO, model, type_unit, sn, engine_brand, engine_model, engine_sn, hp, fuel,  HM, KM
        //     FROM plant_populasi a
        //     JOIN plant_HM b
        //     ON  a.nom_unit=b.nom_unit
        //     JOIN site c
        //     ON b.kodesite = c.kodesite
        //     ".$nama."";
        // }

        // $data = collect(DB::select($subquery));


        $data = DB::table('plant_status_bd')->select(DB::raw("
        plant_status_bd.*, 
        IFNULL(DATEDIFF(curdate(), plant_status_bd.tgl_bd),0) as day,
        site.namasite"))
        ->join('site', 'plant_status_bd.kodesite', '=', 'site.kodesite')
        ->where('status_bd', '=', 1)
        ->when(($nama && $nama!=""), function($query) use($request){
            $query = $query->where('nom_unit', 'like', '%'.$request->cariNama.'%');
        })
        ->when(($request->kodesite && $request->kodesite!='all'), function ($query) use($request){
            $query = $query->where('plant_status_bd.kodesite', '=', $request->kodesite);
        })
        ->orderBy('id')
        ->get();

        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT e.status model, 
        a.kodesite site, 
        COUNT(a.nom_unit) populasi,
        SUM(IF((C.nom_unit IS NULL OR (C.kode_bd='RFU')),1,0)) RFU,
        SUM(IF((C.nom_unit IS NOT NULL AND (C.kode_bd<>'RFU')),1,0)) BD,
        d.namasite namasite,
        d.gambar gambar,
        f.gambar icon_unit
        FROM plant_populasi a
        LEFT JOIN (SELECT * FROM plant_status_bd GROUP BY NOM_UNIT) c
        ON a.nom_unit=c.nom_unit
        JOIN site d
        ON a.kodesite=d.kodesite
        JOIN plant_populasi_bagian e
        ON e.id = a.status_bagian
        JOIN plant_icon_unit f
        ON e.status=f.status
        GROUP BY a.status_bagian, a.kodesite
        ORDER BY d.id, a.status_bagian";
        
        $dataCard = collect(DB::select($subquery));
        $dataCard = $dataCard->mapToGroups(function($data){
            return [$data->site => [
                'model' => $data->model,
                'populasi' => $data->populasi,
                'RFU' => $data->RFU,
                'BD' => $data->BD,
                'gambar' => $data->gambar,
                'icon_unit' => $data->icon_unit,
                'namasite' => $data->namasite,
            ]];
        });


        if($request->has('kodesite') || $request->has('cariNama')){
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('bd-harian.index', compact('data', 'site','dataCard'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Data Utama
        $status = Auth::user()->kodesite === 'X' ? 1 : 0;

        $site = $status ? DB::table('site')->select('kodesite', 'namasite', 'lokasi')->where('status', '=', 1)->get() : DB::table('site')->select('kodesite', 'namasite', 'lokasi')->where('status', '=', 1)->where('kodesite', '=', Auth::user()->kodesite)->get() ;
        $nom_unit = $status ? DB::table("plant_populasi")->select("Nom_unit")->get() : DB::table("plant_populasi")->select("Nom_unit")->where('kodesite', '=', Auth::user()->kodesite)->get() ;
        $kode_bd = DB::table("kode_bd")->select("kode_bd", "deskripsi_bd")->where('kode_bd', '<>', 'NA')->get();
        $dok_type = DB::table("plant_status_bd_dok")->select(DB::raw("DISTINCT dok_type"))->get();
        $dok_tiket = DB::table("plant_status_bd_dok")->select(DB::raw("DISTINCT id_tiket"))->get();

        $dataTable = DB::table("plant_status_bd")->select(DB::raw("id, nom_unit, DATE_FORMAT(tgl_bd,\"%d-%m-%Y\") tgl_bd, DATE_FORMAT(tgl_rfu,\"%d-%m-%Y\") tgl_rfu, ket_tgl_rfu, kode_bd, pic, hm, keterangan"))->orderBy('id', 'desc')->limit(5)->get();

        return view('bd-harian.create', compact('nom_unit', 'kode_bd', 'dok_type', 'dok_tiket', 'site','dataTable'));
    }

    /**
     * Detail
     * 
     * Showing Detail Data
     */
    public function detail($id)
    {
        $data = DB::table('plant_status_bd')->select(DB::raw("
        plant_status_bd.*, 
        DATE_FORMAT(tgl_bd, '%d-%m-%Y') tgl_bd_format,
        DATE_FORMAT(tgl_rfu, '%d-%m-%Y') tgl_rfu_format,
        IFNULL(DATEDIFF(curdate(), plant_status_bd.tgl_bd),0) as day,
        site.namasite,
        kode_bd.kode_bd,
        kode_bd.deskripsi_bd"))
        ->join('site', 'plant_status_bd.kodesite', '=', 'site.kodesite')
        ->join('kode_bd', 'plant_status_bd.status_bd', '=', 'kode_bd.id')
        ->where('plant_status_bd.nom_unit', '=', $id)
        ->orderBy('id')
        ->get();

        $nom_unit = DB::table('plant_status_bd')->select("nom_unit")->where('nom_unit', '=', $id)->get();

        // dataDok Baru
        $subquery = "SELECT a.id id, nodokstream no_st, pn, descript uraian_bd, IF(a.STATUS=1, 'RS', 'SR') dok_type, no_rs dok_no, DATE_FORMAT(tgdok, '%d-%m-%Y') dok_tgl, keterangan uraian, b.namasite
            FROM unit_rssp a
            JOIN site b
            ON a.kodesite=b.kodesite
            WHERE nom_unit='".$nom_unit[0]->nom_unit."'
            ORDER BY a.status DESC, tgdok DESC, dok_no
        ";

        $dataDok=collect(DB::select($subquery));

        if(count($dataDok) === 0){
            $dataDesc = "Data Kosong";
            $dataDok = "Data Kosong";
        }

        $site =  Site::where('status', 1)->get();
        return view('bd-harian.detail', compact('dataDok', 'nom_unit', 'data','site'));
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
            'tgl_bd' => 'required|date',
            'tgl_rfu' => 'required|date|after_or_equal:tgl_bd',
            'ket_tgl_rfu' => 'required',
            'kode_bd' => 'required',
            'pic' => 'required',
            'hm' => 'required',
            'site' => 'required',
        ]);

        $record = Plant_bd::create([
            'nom_unit'          =>  $request->nom_unit,
            'tgl_bd'            =>  $request->tgl_bd,
            'tgl_rfu'           =>  $request->tgl_rfu,
            'ket_tgl_rfu'       =>  $request->ket_tgl_rfu,
            'kode_bd'           =>  $request->kode_bd,
            'pic'               =>  $request->pic,
            'hm'                =>  $request->hm,
            'kodesite'          =>  $request->site,
            'keterangan'        =>  $request->keterangan,
            'status_bd'         =>  1,
        ]);


        if($record){
            return redirect()->route('bd-harian.create')->with(['success' => 'Data Berhasil Ditambah!']);;
        }
        else{
            return redirect()->route('bd-harian.create')->with(['error' => 'Data Gagal Ditambah!']);;
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Data Utama
        $data = Plant_bd::findOrFail($id);
        $nom_unit = DB::table("plant_populasi")->select("Nom_unit")->where('Nom_unit', '=', $data->nom_unit)->get();
        $kode_bd = DB::table("kode_bd")->select("kode_bd")->get();
        $dok_type = DB::table("plant_status_bd_dok")->select(DB::raw("DISTINCT dok_type"))->get();
        $dok_tiket = DB::table("plant_status_bd_dok")->select(DB::raw("DISTINCT id_tiket"))->get();
        $site = DB::table('site')->select('kodesite', 'namasite', 'lokasi')->get();

        return view('bd-harian.edit', compact('nom_unit', 'kode_bd', 'dok_type', 'dok_tiket', 'site', 'data'));
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
            'nom_unit' => 'required',
            'tgl_bd' => 'required',
            'tgl_rfu' => 'required',
            'ket_tgl_rfu' => 'required',
            'kode_bd' => 'required',
            'pic' => 'required',
            'hm' => 'required',
            'site' => 'required',
        ]);

        $record = Plant_bd::findOrFail($id);

        $record->update([
            'nom_unit'          =>  $request->nom_unit,
            'tgl_bd'            =>  $request->tgl_bd,
            'tgl_rfu'           =>  $request->tgl_rfu,
            'ket_tgl_rfu'       =>  $request->ket_tgl_rfu,
            'kode_bd'           =>  $request->kode_bd,
            'pic'               =>  $request->pic,
            'hm'                =>  $request->hm,
            'kodesite'          =>  $request->site,
            'keterangan'        =>  $request->keterangan,
            'status_bd'         =>  $request->kode_bd[1],
        ]);

        $model = PlantOvh::select('model')->where('nom_unit', 'like', '%'.substr($request->nom_unit,0,4).'%')->limit(1)->get();
        if($request->kode_bd === 'RFU'){
            PlantOvh::create([
                'nom_unit'          =>  $request->nom_unit,
                'model'             =>  $model[0]->model,
                'komponen'          =>  "DIFF CENTER",
                'ovh_start'             =>  $request->tgl_bd,
                'ovh_end'            =>  $request->tgl_rfu ? $request->tgl_rfu : Carbon::now(),
                'hm'                =>  $request->hm,
                'remark'            =>  $request->keterangan,
            ]);
        }

        if($record){
            return redirect()->route('super_admin.bd-harian.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('super_admin.bd-harian.index')->with(['error' => 'Data Gagal Diupdate!']);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteData($id)
    {
        $record = Plant_bd::findOrFail($id)->update([
            'del' =>  0,
        ]);

        if($record){
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil Dihapus'
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak berhasil Dihapus'
            ]);
        }
    }


    public function showFilter(Request $request)
    {        
        if($request->has('kodesite') && $request->kodesite !== 'all'){
            $subquery = "SELECT a.id id,
            nodokstream no_st, 
            '', 
            descript uraian_bd, 
            IF(a.STATUS=1, 
            'RS', 
            'SR') dok_type, 
            no_rs dok_no, 
            DATE_FORMAT(tgdok, '%d-%m-%Y') dok_tgl, 
            keterangan uraian, 
            b.namasite namasite
            FROM unit_rssp a
            JOIN site b
            ON a.kodesite=b.kodesite
            WHERE nom_unit='".$request->nom_unit."' AND a.kodesite='".$request->kodesite."'
            ORDER BY a.status DESC";
        } else {
            $subquery = "SELECT nodokstream no_st, 
            '', 
            descript uraian_bd, 
            IF(a.STATUS=1, 'RS', 'SR') dok_type, 
            no_rs dok_no, 
            DATE_FORMAT(tgdok, '%d-%m-%Y') dok_tgl, 
            keterangan uraian, 
            b.namasite namasite
            FROM unit_rssp a
            JOIN site b
            ON a.kodesite=b.kodesite
            WHERE nom_unit='".$request->nom_unit."'
            ORDER BY a.status DESC";
        }

        $data = collect(DB::select($subquery));

        $response['data'] = $data;
        return response()->json($response);  
    } 

    public function showModel(Request $request)
    {   
        $where = '';
        
        if($request->has('cari')){
            $where .= "and ";
            $where .= ($request->has('cari') && !empty($request->cari)) ? "a.nom_unit LIKE '%" . $request->cari . "%'" : "";
            $where .= (!empty($request->cari) && $request->has('cari') && !empty($request->cari)) ? " OR " : "";
            $where .= ($request->has('cari') && !empty($request->cari)) ? "keterangan LIKE '%" . $request->cari . "%'" : "";
            // Last Condition
            $where .= "AND a.DEL=0";    
        }

        $model = DB::table("plant_populasi_bagian")->select('id')->where('status','=',$request->model)->pluck('id');

        $subquery = "SELECT e.status model, 
        a.kodesite site, 
        COUNT(a.nom_unit) populasi,        
        SUM(IF((C.nom_unit IS NULL OR (C.kode_bd='RFU')),1,0)) RFU,
        SUM(IF((C.nom_unit IS NOT NULL AND (C.kode_bd<>'RFU')),1,0)) BD,
        d.namasite namasite,
        d.gambar gambar,
        f.gambar icon_unit
        FROM plant_populasi a
        LEFT JOIN plant_status_bd c
        ON a.nom_unit=c.nom_unit
        JOIN site d
        ON a.kodesite=d.kodesite
        JOIN plant_populasi_bagian e
        ON e.id = a.status_bagian
        JOIN plant_icon_unit f
        ON e.status=f.status
        WHERE d.namasite='".$request->site."' AND e.id=".$model[0]."
        GROUP BY a.status_bagian, a.kodesite
        ORDER BY d.id, a.status_bagian";
        $data = collect(DB::select($subquery));

        $subquery = "SELECT a.nom_unit,
        a.type_unit
        FROM plant_populasi a
        LEFT JOIN plant_status_bd c
        ON a.nom_unit=c.nom_unit
        JOIN site d
        ON a.kodesite=d.kodesite
        JOIN plant_populasi_bagian e
        ON e.id = a.status_bagian
        JOIN plant_icon_unit f
        ON e.status=f.status
        WHERE d.namasite='".$request->site."' AND e.id=".$model[0]." AND (C.nom_unit IS NULL OR (C.kode_bd='RFU'))
        group by a.nom_unit
        ORDER BY a.nom_unit, d.id, a.status_bagian";
        $dataRFU = collect(DB::select($subquery));
        
        $subquery = "SELECT c.id, 
        a.nom_unit,
        a.type_unit,
        date_format(c.tgl_bd, \"%d-%m-%Y\") tgl_bd,
        date_format(c.tgl_rfu, \"%d-%m-%Y\") tgl_rfu,
        c.ket_tgl_rfu,
        c.kode_bd,
        c.pic,
        c.keterangan
        FROM plant_populasi a
        JOIN plant_hm b
        ON a.nom_unit=b.nom_unit
        LEFT JOIN plant_status_bd c
        ON a.nom_unit=c.nom_unit
        JOIN site d
        ON a.kodesite=d.kodesite
        JOIN plant_populasi_bagian e
        ON e.id = a.status_bagian
        JOIN plant_icon_unit f
        ON e.status=f.status
        WHERE d.namasite='".$request->site."' AND e.id=".$model[0]." and (C.nom_unit IS NOT NULL AND (C.kode_bd<>'RFU')) ".$where."
        group by c.id
        ORDER BY a.nom_unit, d.id, a.status_bagian";
        $dataBD = collect(DB::select($subquery));
        // Site
        $site = Site::all()->where('status', 1);

        // Data Filter
        $siteMenu = $request->site;
        $model = DB::table('Plant_populasi_bagian')->select('status')->where('id', '=', $model[0])->pluck('status');
        $model = $model[0];
                

        if ($request->has('cari')) {
            $response['data'] = $dataBD;
            return response()->json($response);
        } else {
            return view('bd-harian.showModel', compact('data', 'dataRFU', 'dataBD', 'site', 'siteMenu', 'model'));
        }
    }
}
