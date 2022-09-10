<?php

namespace App\Http\Controllers;

use App\Models\Plant_bd;
use App\Models\Site;
use Illuminate\Http\Request;
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

        if($request->has('kodesite') || $request->has('cariNama')){
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('bd-harian.index', compact('data', 'site'));
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
        $nom_unit = DB::table("plant_populasi")->select("Nom_unit")->get();
        $kode_bd = DB::table("kode_bd")->select("kode_bd", "deskripsi_bd")->where('kode_bd', '<>', 'NA')->get();
        $dok_type = DB::table("plant_status_bd_dok")->select(DB::raw("DISTINCT dok_type"))->get();
        $dok_tiket = DB::table("plant_status_bd_dok")->select(DB::raw("DISTINCT id_tiket"))->get();
        $site = DB::table('site')->select('kodesite', 'namasite', 'lokasi')->where('status', '=', 1)->get();

        return view('bd-harian.create', compact('nom_unit', 'kode_bd', 'dok_type', 'dok_tiket', 'site'));
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
        ->where('plant_status_bd.id', '=', $id)
        ->orderBy('id')
        ->get();

        $nom_unit = DB::table('plant_status_bd')->select("nom_unit")->where('id', '=', $id)->get();

        // dataDok lama
        // $dataDok = DB::table('plant_status_bd')
        // ->select('plant_status_bd_dok.id', 'plant_status_bd.nom_unit', 'plant_status_bd_dok.dok_type', 'plant_status_bd_dok.dok_no', 'plant_status_bd_dok.dok_tgl', 'plant_status_bd_dok.uraian_bd', 'plant_status_bd_dok.kode_bd', 'plant_status_bd_dok.uraian', 'plant_status_bd_dok.keterangan')
        // ->join('plant_status_bd_dok', 'plant_status_bd.id', '=', 'plant_status_bd_dok.id_tiket')
        // ->where('plant_status_bd.id', '=', $id)
        // ->where('plant_status_bd_dok.del', '=', 0)
        // ->get();

        // dataDok Baru
        $subquery = "SELECT nodokstream no_st, '', descript uraian_bd, IF(STATUS=1, 'RS', 'SR') dok_type, no_rs dok_no, DATE_FORMAT(tgdok, '%d-%m-%Y') dok_tgl, keterangan uraian
            FROM unit_rssp
            WHERE nom_unit='".$nom_unit[0]->nom_unit."'
        ";

        $dataDok=collect(DB::select($subquery));

        if(count($dataDok) === 0){
            $dataDesc = "Data Kosong";
            $dataDok = "Data Kosong";
        }

        return view('bd-harian.detail', compact('dataDok', 'nom_unit', 'data'));
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
            'tgl_bd' => 'required',
            'tgl_rfu' => 'required',
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
            return redirect()->route('super_admin.bd-harian.index')->with(['success' => 'Data Berhasil Ditambah!']);;
        }
        else{
            return redirect()->route('super_admin.bd-harian.index')->with(['error' => 'Data Gagal Ditambah!']);;
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
            'keterangan'        =>  "Testing",
            'status_bd'         =>  $request->kode_bd[1],
        ]);

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
}
