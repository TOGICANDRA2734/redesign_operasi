<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionTpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = '';

        if (count($request->all()) > 1) {              
            // Where 1
            $where .= ($request->has('start') && $request->has('end')) ? "tgl BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where .= ($request->has('kodesite') && !empty($request->kodesite)) ? "kodesite='" . $request->kodesite . "'" : "";
            $where .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $where .= ($request->has('cariNama') && !empty($request->cariNama)) ? "nom_unit LIKE '%" . $request->cariNama . "%'" : "";
            $where .= " AND del=0";
        } else {
            $where .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT
        LEFT(nom_unit,4) gol,
        COALESCE(nom_unit, \"SUB TOTAL\") nom_unit,
        SUM(IF(aktivitas=\"001\",jam,0))hlg,
        SUM(IF(aktivitas=\"003\",jam,0))rom,
        SUM(IF(aktivitas=\"004\",jam,0))pot,
        SUM(IF(aktivitas=\"015\",jam,0))trv,
        SUM(IF(aktivitas=\"020\",jam,0))gen,
        SUM(IF(aktivitas=\"023\",jam,0))rnt,
        SUM(IF(LEFT(aktivitas,1)=\"0\",jam,0))wh,
        SUM(IF(LEFT(aktivitas,1)=\"B\",jam,0))bd,
        SUM(IF(LEFT(aktivitas,1)=\"S\",jam,0))stb,
        SUM(jam) mohh,
        (((SUM(jam)-SUM(IF(LEFT(aktivitas,1)='B',jam,0)))/SUM(jam))*100) ma,
        ((SUM(IF(LEFT(aktivitas,1)='0',jam,0))/(SUM(jam)-SUM(IF(LEFT(aktivitas,1)='B',jam,0))))*100) ut,
        SUM(IF(aktivitas=\"S00\",jam,0))s00,
        SUM(IF(aktivitas=\"S01\",jam,0))s01,
        SUM(IF(aktivitas=\"S02\",jam,0))s02,
        SUM(IF(aktivitas=\"S03\",jam,0))s03,
        SUM(IF(aktivitas=\"S04\",jam,0))s04,
        SUM(IF(aktivitas=\"S05\",jam,0))s05,
        SUM(IF(aktivitas=\"S06\",jam,0))s06,
        SUM(IF(aktivitas=\"S07\",jam,0))s07,
        SUM(IF(aktivitas=\"S08\",jam,0))s08,
        SUM(IF(aktivitas=\"S09\",jam,0))s09,
        SUM(IF(aktivitas=\"S10\",jam,0))s10,
        SUM(IF(aktivitas=\"S11\",jam,0))s11,
        SUM(IF(aktivitas=\"S12\",jam,0))s12,
        SUM(IF(aktivitas=\"S13\",jam,0))s13,
        SUM(IF(aktivitas=\"S14\",jam,0))s14,
        SUM(IF(aktivitas=\"S15\",jam,0))s15,
        SUM(IF(aktivitas=\"S16\",jam,0))s16,
        SUM(IF(aktivitas=\"S17\",jam,0))s17
        
        FROM pma_tp
        WHERE ".$where."
        GROUP BY gol,nom_unit WITH ROLLUP
        ";
        $data = collect(DB::select(DB::raw($subquery)));
      
        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('distributionTp.index', compact('data', 'site'));
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
