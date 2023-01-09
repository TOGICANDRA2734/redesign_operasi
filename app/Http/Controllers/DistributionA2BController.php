<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionA2BController extends Controller
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
        SUM(IF(kode=\"001\",jam,0))lc,
        SUM(IF(kode=\"003\",jam,0))rip,
        SUM(IF(kode=\"004\",jam,0))doz,
        SUM(IF(kode=\"005\",jam,0))rp,
        SUM(IF(kode=\"006\",jam,0))spr,
        SUM(IF(kode=\"008\",jam,0))lr,
        SUM(IF(kode=\"009\",jam,0))ll,
        SUM(IF(kode=\"010\",jam,0))ls,
        SUM(IF(kode=\"011\",jam,0))lb,
        SUM(IF(kode=\"012\",jam,0))lm,
        SUM(IF(kode=\"013\",jam,0))lcoal,
        SUM(IF(kode=\"017\",jam,0))ob_maint,
        SUM(IF(kode=\"022\",jam,0))drill,
        SUM(IF(kode=\"018\",jam,0))coal_maint,
        SUM(IF(kode=\"015\",jam,0))trv,
        SUM(IF(kode=\"020\",jam,0))gen,
        SUM(IF(kode=\"023\",jam,0))rent,

        -- SUM(IF(kode=\"014\",jam,0))ccln,
        SUM(IF(LEFT(kode,1)=\"0\",jam,0))wh,

        SUM(jam) mohh,
        SUM(IF(LEFT(kode,1)=\"B\",jam,0))bd,
        SUM(IF(LEFT(kode,1)=\"S\",jam,0))stb,
        (((SUM(jam)-SUM(IF(LEFT(kode,1)='B',jam,0)))/SUM(jam))*100) ma,
        ((SUM(IF(LEFT(kode,1)='0',jam,0))/(SUM(jam)-SUM(IF(LEFT(kode,1)='B',jam,0))))*100) ut,
        SUM(IF(kode=\"S00\",jam,0))s00,
        SUM(IF(kode=\"S01\",jam,0))s01,
        SUM(IF(kode=\"S02\",jam,0))s02,
        SUM(IF(kode=\"S03\",jam,0))s03,
        SUM(IF(kode=\"S04\",jam,0))s04,
        SUM(IF(kode=\"S05\",jam,0))s05,
        SUM(IF(kode=\"S06\",jam,0))s06,
        SUM(IF(kode=\"S07\",jam,0))s07,
        SUM(IF(kode=\"S08\",jam,0))s08,
        SUM(IF(kode=\"S09\",jam,0))s09,
        SUM(IF(kode=\"S10\",jam,0))s10,
        SUM(IF(kode=\"S11\",jam,0))s11,
        SUM(IF(kode=\"S12\",jam,0))s12,
        SUM(IF(kode=\"S13\",jam,0))s13,
        SUM(IF(kode=\"S14\",jam,0))s14,
        SUM(IF(kode=\"S15\",jam,0))s15,
        SUM(IF(kode=\"S16\",jam,0))s16,
        SUM(IF(kode=\"S17\",jam,0))s17
        FROM pma_a2b
        WHERE ".$where."
        GROUP BY gol,nom_unit WITH ROLLUP
        ";
        $data = collect(DB::select(DB::raw($subquery)));
      
        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('distributionA2B.index', compact('data', 'site'));
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
