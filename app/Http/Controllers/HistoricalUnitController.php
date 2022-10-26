<?php

namespace App\Http\Controllers;

use App\Models\Plant_Populasi;
use App\Models\RSSP;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('cariNama')){
            $subquery = "SELECT nodok, nom_unit, no_rs, nodokstream, tgdok, pn, descript, kodesite 
            FROM unit_rssp 
            WHERE nodokstream LIKE '%".$request->cariNama."%'";
        } else {
            $subquery = "SELECT nodok, nom_unit, no_rs, nodokstream, tgdok, pn, descript, kodesite 
            FROM unit_rssp
            LIMIT 100";
        }

        $data = collect(DB::select($subquery));

        $site = Site::where('status', 1)->get();
        
        if($request->has('cariNama')){
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('historical-unit.index', compact('data', 'site'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nom_unit = Plant_Populasi::select('nom_unit')->where('nom_unit', $id)->pluck('nom_unit');
        $id = Plant_Populasi::where('nom_unit', $id)->get()->pluck('id');
        $data = Plant_Populasi::findOrFail($id);
        $site = Site::where('status', 1)->get();

        // Data
        $subquery = "SELECT descript,
            CASE WHEN b.status=1 THEN 'RS'
            WHEN b.STATUS=6 THEN 'SR'
            END 'status_sr', 
            b.hm, 
            DATE_FORMAT(b.tgdok, '%d-%m-%Y') tanggal,
            mechanic,
            c.namasite
            FROM plant_populasi a
            JOIN unit_rssp b
            ON a.nom_unit = b.nom_unit
            JOIN site c
            ON b.kodesite = c.kodesite
            WHERE a.nom_unit='" . $data[0]->nom_unit . "'
            ORDER BY status_sr desc,b.tgdok desc, c.namasite asc";
        $data = DB::select($subquery);

        return view('historical-unit.show', compact('data', 'site','nom_unit'));
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
        if($request->cariNama!==null && $request->kodesite !==null){
            $nama =  "AND a.NOM_UNIT LIKE \"%".$request->cariNama."%\"";
        }
        else if($request->has('cariNama') && $request->cariNama !== null){
            $nama =  "AND a.NOM_UNIT LIKE \"%".$request->cariNama."%\"";
        } else {
            $nama = "";
        }

        if($request->has('kodesite') && $request->kodesite !== 'all'){
            $subquery = "SELECT descript,
            CASE WHEN b.status=1 THEN 'RS'
            WHEN b.STATUS=6 THEN 'SR'
            END status_sr, 
            b.hm AS hm_fix, 
            DATE_FORMAT(b.tgdok, '%d-%m-%Y') AS tanggal,
            mechanic AS PIC,
            c.namasite namasite
            FROM plant_populasi a
            JOIN unit_rssp b
            ON a.nom_unit = b.nom_unit
            JOIN site c
            ON b.kodesite = c.kodesite
            WHERE a.nom_unit='" . $request->nom_unit . "' AND b.kodesite='".$request->kodesite."' ".$nama."
            ORDER BY b.tgdok";
        } else {
            $subquery = "SELECT descript,
            CASE WHEN b.status=1 THEN 'RS'
            WHEN b.STATUS=6 THEN 'SR'
            END status_sr, 
            b.hm AS hm_fix, 
            DATE_FORMAT(b.tgdok, '%d-%m-%Y') AS tanggal,
            mechanic AS PIC,
            c.namasite namasite
            FROM plant_populasi a
            JOIN unit_rssp b
            ON a.nom_unit = b.nom_unit
            JOIN site c
            ON b.kodesite = c.kodesite
            WHERE a.nom_unit='" . $request->nom_unit . "' ".$nama."
            ORDER BY b.tgdok";
        }

        $data = collect(DB::select($subquery));

        $response['data'] = $data;
        return response()->json($response);
        
    }
}
