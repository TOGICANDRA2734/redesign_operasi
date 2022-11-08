<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $whereTp = '';
        $whereA2b = '';
        $whereFuel = '';

        if (count($request->all()) > 1) {              
            // WhereTP
            $whereTp .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $whereTp .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $whereTp .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "kodesite='" . $request->pilihSite . "'" : "";
            $whereTp .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $whereTp .= ($request->has('cariNama') && !empty($request->cariNama)) ? "tp.nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $whereTp .= "AND DEL=0";

            // WhereA2b
            $whereA2b .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $whereA2b .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $whereA2b .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "kodesite='" . $request->pilihSite . "'" : "";
            $whereA2b .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $whereA2b .= ($request->has('cariNama') && !empty($request->cariNama)) ? "a2b.nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $whereA2b .= "AND DEL=0";


            // WherePmaFuel
            $whereFuel .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $whereFuel .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $whereFuel .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "kodesite='" . $request->pilihSite . "'" : "";
            $whereFuel .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $whereFuel .= ($request->has('cariNama') && !empty($request->cariNama)) ? "pma_fuel.nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $whereFuel .= "AND DEL=0";
        } else {
            $whereTp .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND DEL=0";
            $whereA2b .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND DEL=0";
            $whereFuel .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND DEL=0";
        }

        $site = Site::where('status_website', 1)->get();
        $subquery = "WITH summ AS
        (
        SELECT
        A.tgl,
        DATE_FORMAT(A.tgl,'%a') hari,
        A.bcm ob_act,
        B.ob ob_pln,
        B.coal coal_pln,
        C.coal coal_act
        
        FROM pma_tp A
        
        LEFT JOIN (SELECT * FROM pma_dailyprod_tc WHERE tgl BETWEEN '2022-07-01' AND '2022-09-01' AND kodesite='I') C ON C.tgl=A.tgl
        LEFT JOIN (SELECT * FROM pma_dailyprod_plan WHERE tgl BETWEEN '2022-07-01' AND '2022-09-01' AND kodesite='I') B ON B.tgl=A.tgl
        
        WHERE a.tgl BETWEEN '2022-07-01' AND '2022-09-01' AND a.kodesite='I'
        GROUP BY A.tgl
        )
        SELECT
            Date_format(tgl, \"%d-%m-%Y\") tgl_format,
            hari,
            FORMAT(IFNULL(ob_pln,0),1) ob_plan,
            FORMAT(IFNULL(ob_act,0),1) ob_act,
            FORMAT(IFNULL(ob_act/ob_pln * 100,0),1) ob_ach,
            FORMAT(IFNULL(coal_pln,0),1) coal_plan,
            FORMAT(IFNULL(coal_act,0),1) coal_act,
            FORMAT(IFNULL(coal_act/coal_pln  *100, 0),1) coal_ach
        FROM summ
        ORDER BY year(tgl), month(tgl), day(tgl)";

        $data = collect(DB::select($subquery));

        if ($request->has('start') || $request->has('end') || $request->has('pilihSite') || $request->has('cariNama')) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('daily-production.index', compact('site', 'data'));
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
