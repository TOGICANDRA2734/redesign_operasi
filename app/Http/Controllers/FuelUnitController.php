<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuelUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where1 = '';
        $where2 = '';
        $where3 = '';

        if (count($request->all()) > 1) {              
            // Where 1
            $where1 .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            // $where1 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            // $where1 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "kodesite='" . $request->kodesite . "'" : "";
            $where1 .= " AND del=0";

            // Where 2
            $where2 .= ($request->has('start') && $request->has('end')) ? "a.TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "a.kodesite='" . $request->kodesite . "'" : "";
            $where2 .= " AND a.del=0";
            
            // Where 3
            $where3 .= ($request->has('start') && $request->has('end')) ? "e.TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where3 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where3 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "e.kodesite='" . $request->kodesite . "'" : "";
            $where3 .= " AND e.del=0";
        } else {
            $where1 .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
            $where2 .= "a.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND a.del=0";
            $where3 .= "e.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND e.del=0";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "-- PMA_A2B
        (
        SELECT a.nom_unit, 
        DATE_FORMAT(a.tgl, '%b') tgl, 
        FORMAT(SUM(qty),0) liter, 
        FORMAT(jam, 0) jam,
        FORMAT(SUM(qty)/ (jam), 2) ltr_hour,
        0 ltr_bcm,
        namasite
        FROM pma_fuel a
        JOIN (SELECT nom_unit, 
        MONTH(tgl) tgl, 
        SUM(IF(LEFT(kode,1)='0',jam,0)) jam
        FROM pma_a2b 
        WHERE ".$where1."
        GROUP BY MONTH(tgl), 
        nom_unit) b
        ON a.nom_unit=b.nom_unit 
        JOIN (SELECT namasite, kodesite FROM site ) c 
        ON a.kodesite=c.kodesite
        JOIN (SELECT * FROM unit_urut) d
        ON LEFT(a.nom_unit,4)=kode_left
        WHERE ".$where2."
        GROUP BY MONTH(a.tgl), a.nom_unit 
        ORDER BY gol, MONTH(a.tgl), a.nom_unit 
        )
        
        UNION ALL
        
        (
        -- PMA_TP
        SELECT e.nom_unit, 
        DATE_FORMAT(e.tgl, '%b') tgl, 
        FORMAT(SUM(qty),0) liter, 
        FORMAT(jam, 0) jam,
        FORMAT(SUM(qty)/jam, 2) ltr_hour,
        FORMAT(SUM(qty)/bcm, 2) ltr_bcm,
        namasite
        FROM (SELECT * FROM pma_fuel) e
        JOIN (SELECT nom_unit, 
        MONTH(tgl) tgl, 
        SUM(IF(LEFT(aktivitas,1)='0', jam, 0)) jam,
        SUM(bcm) bcm,
        aktivitas
        FROM pma_tp
        WHERE ".$where1."
        GROUP BY MONTH(tgl), 
        nom_unit) f
        ON e.nom_unit=f.nom_unit 
        JOIN (SELECT namasite, kodesite FROM site ) g
        ON e.kodesite=g.kodesite
        JOIN (SELECT * FROM unit_urut) h
        ON LEFT(e.nom_unit,4)=kode_left
        WHERE ".$where3."
        GROUP BY MONTH(e.tgl), e.nom_unit 
        ORDER BY gol, MONTH(e.tgl), e.nom_unit 
        )";
        $data = collect(DB::select(DB::raw($subquery)));

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('fuel-unit.index', compact('data', 'site'));
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
