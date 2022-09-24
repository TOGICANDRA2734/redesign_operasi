<?php

namespace App\Http\Controllers;

use App\Models\Plant_bd;
use App\Models\Plant_Populasi;
use App\Models\Site;
use Carbon\Carbon;
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

        $subquery = "SELECT e.status model, 
        b.kodesite site, 
        COUNT(b.nom_unit) populasi,
        SUM(IF((C.nom_unit IS NULL OR (C.ket_tgl_rfu='RFU' AND C.status_bd=0)),1,0)) RFU,
        SUM(IF((C.nom_unit IS NOT NULL AND (C.ket_tgl_rfu<>'RFU' AND C.status_bd=1)),1,0)) BD,
        d.namasite namasite,
        d.gambar gambar,
        f.gambar icon_unit
        FROM plant_populasi a
        JOIN plant_hm b
        ON a.nom_unit=b.nom_unit
        LEFT JOIN plant_status_bd c
        ON a.nom_unit=c.nom_unit
        JOIN site d
        ON b.kodesite=d.kodesite
        JOIN plant_populasi_bagian e
        ON e.id = a.status_bagian
        JOIN plant_icon_unit f
        ON e.status=f.status
        GROUP BY a.status_bagian, b.kodesite
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

        ->where('plant_status_bd.nom_unit', '=', $id)
        ->orderBy('id')
        ->get();

        $nom_unit = DB::table('plant_status_bd')->select("nom_unit")->where('nom_unit', '=', $id)->get();

        // dataDok Baru
        $subquery = "SELECT a.id id, nodokstream no_st, '', descript uraian_bd, IF(a.STATUS=1, 'RS', 'SR') dok_type, no_rs dok_no, DATE_FORMAT(tgdok, '%d-%m-%Y') dok_tgl, keterangan uraian, b.namasite, pr_type, pr_prd, sq_no, pr_date, dept_code, vend_code, item_code, item_qty, pr_desc_4
            FROM unit_rssp a
            JOIN site b
            ON a.kodesite=b.kodesite
            JOIN unit_po_req c
            on c.ref_no=a.nodokstream
            WHERE nom_unit='".$nom_unit[0]->nom_unit."'
            ORDER BY a.status DESC, tgdok DESC
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
            WHERE nom_unit='".$request->nom_unit."' AND a.kodesite='".$request->kodesite."'";
        } else {
            $subquery = "SELECT nodokstream no_st, '', descript uraian_bd, IF(a.STATUS=1, 'RS', 'SR') dok_type, no_rs dok_no, DATE_FORMAT(tgdok, '%d-%m-%Y') dok_tgl, keterangan uraian, b.namasite namasite
            FROM unit_rssp a
            JOIN site b
            ON a.kodesite=b.kodesite
            WHERE nom_unit='".$request->nom_unit."'";
        }

        $data = collect(DB::select($subquery));

        $response['data'] = $data;
        return response()->json($response);  
    } 

    public function showModel(Request $request)
    {
        $subquery = "SELECT e.status model, 
        b.kodesite site, 
        COUNT(b.nom_unit) populasi,
        SUM(IF((C.nom_unit IS NULL OR (C.ket_tgl_rfu='RFU' AND C.status_bd=0)),1,0)) RFU,
        SUM(IF((C.nom_unit IS NOT NULL AND (C.ket_tgl_rfu<>'RFU' AND C.status_bd=1)),1,0)) BD,
        d.namasite namasite,
        d.gambar gambar,
        f.gambar icon_unit
        FROM plant_populasi a
        JOIN plant_hm b
        ON a.nom_unit=b.nom_unit
        LEFT JOIN plant_status_bd c
        ON a.nom_unit=c.nom_unit
        JOIN site d
        ON b.kodesite=d.kodesite
        JOIN plant_populasi_bagian e
        ON e.id = a.status_bagian
        JOIN plant_icon_unit f
        ON e.status=f.status
        WHERE d.namasite='".$request->site."' AND e.status LIKE '%".$request->model."%'
        GROUP BY a.status_bagian, b.kodesite
        ORDER BY d.id, a.status_bagian";
        $data = collect(DB::select($subquery));

        $subquery = "SELECT a.nom_unit,
        a.type_unit
        FROM plant_populasi a
        JOIN plant_hm b
        ON a.nom_unit=b.nom_unit
        LEFT JOIN plant_status_bd c
        ON a.nom_unit=c.nom_unit
        JOIN site d
        ON b.kodesite=d.kodesite
        JOIN plant_populasi_bagian e
        ON e.id = a.status_bagian
        JOIN plant_icon_unit f
        ON e.status=f.status
        WHERE d.namasite='".$request->site."' AND e.status LIKE '%".$request->model."%' AND C.nom_unit IS NULL OR (C.ket_tgl_rfu='RFU' AND C.status_bd=0)
        ORDER BY d.id, a.status_bagian";
        $dataRFU = collect(DB::select($subquery));

        
        $subquery = "SELECT a.nom_unit,
        a.type_unit
        FROM plant_populasi a
        JOIN plant_hm b
        ON a.nom_unit=b.nom_unit
        LEFT JOIN plant_status_bd c
        ON a.nom_unit=c.nom_unit
        JOIN site d
        ON b.kodesite=d.kodesite
        JOIN plant_populasi_bagian e
        ON e.id = a.status_bagian
        JOIN plant_icon_unit f
        ON e.status=f.status
        WHERE d.namasite='".$request->site."' AND e.status LIKE '%".$request->model."%' AND C.nom_unit IS NOT NULL AND (C.ket_tgl_rfu<>'RFU' AND C.status_bd=1)
        ORDER BY d.id, a.status_bagian";
        $dataBD = collect(DB::select($subquery));


        return view('bd-harian.showModel', compact('data', 'dataRFU', 'dataBD'));
    }
}
