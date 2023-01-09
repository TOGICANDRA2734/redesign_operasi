<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PtyTpController extends Controller
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

        if (count($request->all()) > 1) {              
            // Where 1
            $where1 .= ($request->has('start') && $request->has('end')) ? "tgl BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where1 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where1 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "kodesite='" . $request->kodesite . "'" : "";
            $where1 .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $where1 .= ($request->has('cariNama') && !empty($request->cariNama)) ? "nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $where1 .= " AND del=0";

            // Where 2
            $where2 .= ($request->has('start') && $request->has('end')) ? "a.tgl BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "a.kodesite='" . $request->kodesite . "'" : "";
            $where2 .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $where2 .= ($request->has('cariNama') && !empty($request->cariNama)) ? "a.nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $where2 .= " AND a.del=0";
        } else {
            $where1 .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
            $where2 .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT
        (LEFT(a.nom_unit,4)) gol,
        COALESCE(a.nom_unit, \"SUB TOTAL\") nom_unit,
        SUM(IF(LEFT(a.aktivitas,1)=\"0\",a.jam,0)) wh,
        SUM(IF(LEFT(a.aktivitas,1)=\"s\",a.jam,0)) stb,
        SUM(IF(LEFT(a.aktivitas,1)=\"b\",a.jam,0)) bd,
        SUM(a.jam) mohh,
        SUM(a.bcm) bcm,
        -- SUM(IF(a.aktivitas=\"001\",a.jam,0)) wh_ob,
        (sum(distbcm)/sum(bcm)) jarak,
        (SUM(a.bcm)/SUM(IF(aktivitas=\"001\",a.jam,0))) pty,
        b.fuel,
        (b.fuel/SUM(IF(LEFT(a.aktivitas,1)=\"0\",a.jam,0))) ltr_wh,
        (b.fuel/SUM(a.bcm)) ltr_bcm,
        (((SUM(a.jam)-SUM(IF(LEFT(a.aktivitas,1)='B',a.jam,0)))/SUM(a.jam))*100) ma,
        ((SUM(IF(LEFT(a.aktivitas,1)='0',a.jam,0))/(SUM(a.jam)-SUM(IF(LEFT(a.aktivitas,1)='B',a.jam,0))))*100) ut
        FROM pma_tp a

        JOIN

        (
        SELECT
        nom_unit,
        SUM(qty) fuel
        FROM pma_fuel
        WHERE ".$where1."
        GROUP BY nom_unit
        ) b

        ON a.nom_unit = b.nom_unit

        WHERE ".$where2."
        GROUP BY gol,a.nom_unit WITH ROLLUP";
        $data = collect(DB::select(DB::raw($subquery)));
      
        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('ptyTp.index', compact('data', 'site'));
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
