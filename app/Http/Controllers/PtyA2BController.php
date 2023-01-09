<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PtyA2BController extends Controller
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
            $where1 .= ($request->has('start') && $request->has('end')) ? "tgl BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where1 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where1 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "kodesite='" . $request->kodesite . "'" : "";
            $where1 .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $where1 .= ($request->has('cariNama') && !empty($request->cariNama)) ? "unit_load LIKE '%" . $request->cariNama . "%'" : "";
            $where1 .= " AND del=0";

            // Where 2
            $where2 .= ($request->has('start') && $request->has('end')) ? "tgl BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "kodesite='" . $request->kodesite . "'" : "";
            $where2 .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $where2 .= ($request->has('cariNama') && !empty($request->cariNama)) ? "nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $where2 .= " AND del=0";

            // Where 2
            $where3 .= ($request->has('start') && $request->has('end')) ? "a.tgl BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where3 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where3 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "a.kodesite='" . $request->kodesite . "'" : "";
            $where3 .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $where3 .= ($request->has('cariNama') && !empty($request->cariNama)) ? "a.nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $where3 .= " AND a.del=0";
        } else {
            $where1 .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
            $where2 .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
            $where3 .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "WITH summ AS
        (
            (	
            SELECT
            LEFT(a.nom_unit,4) gol,
            a.nom_unit,
            SUM(jam) mohh,
            SUM(IF(LEFT(kode,1)=\"S\",jam,0)) stb,
            SUM(IF(LEFT(kode,1)=\"B\",jam,0)) bd,
            SUM(IF(LEFT(kode,1)=\"0\",jam,0)) wh,
            SUM(IF((kode=\"008\") OR
                  (kode=\"009\") OR
                      (kode=\"010\") OR
                      (kode=\"011\") OR
                      (kode=\"012\"),jam,0)) AS wh_ob,
                (B.prod) AS bcm,
                (B.distbcm) AS distbcm,
                c.fuel
            FROM pma_a2b a
            JOIN (SELECT unit_load, SUM(bcm) AS prod, SUM(distbcm) distbcm, SUM(ritasi) rit FROM pma_tp WHERE ".$where1." GROUP BY unit_load) b
            ON a.nom_unit=b.unit_load
            join (select nom_unit, sum(qty)fuel from pma_fuel where ".$where2." GROUP BY nom_unit) c
            ON a.nom_unit = c.nom_unit 
            WHERE ".$where3."
            GROUP BY a.nom_unit
            )
        
        )
        SELECT 
        gol,
        COALESCE(nom_unit, \"SUB TOTAL\") nom_unit,
        -- SUM(wh) wh,
        SUM(wh_ob) wh_ob,
        SUM(stb) stb,
        SUM(bd) bd,

        SUM(mohh) mohh,
        SUM(bcm) bcm,
        (sum(distbcm)/sum(bcm)) distbcm,
        (SUM(bcm)/SUM(wh_ob)) pty,
        sum(fuel) fuel,
        (sum(fuel)/sum(wh)) fuel_wh,
        (sum(fuel)/sum(bcm)) fuel_bcm,
        (((SUM(mohh)-SUM(bd))/SUM(mohh))*100) ma,
        (sum(wh)/(sum(mohh)-sum(bd))*100) ut
        FROM summ
        GROUP BY gol, nom_unit WITH ROLLUP";
        $data = collect(DB::select(DB::raw($subquery)));
      
        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('ptyA2B.index', compact('data', 'site'));
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
