<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaHarianController extends Controller
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

        $subquery = "WITH summ AS
        (
        SELECT
        tgl,
        LEFT(nom_unit,4) gol,
        SUM(jam) mohh,
        SUM(IF(LEFT(aktivitas,1)=\"B\",jam,0)) bd,
        (((SUM(jam)-SUM(IF(LEFT(aktivitas,1)=\"B\",jam,0)))/SUM(jam))*100) ma
        FROM pma_tp
        WHERE ".$where."
        GROUP BY tgl,gol
        )
        SELECT
        gol,
        (((SUM(mohh)-SUM(bd))/SUM(mohh))*100) ma,
        SUM(CASE WHEN (DAY(tgl)=1) THEN ma END)  t1,
        SUM(CASE WHEN (DAY(tgl)=2) THEN ma END)  t2,
        SUM(CASE WHEN (DAY(tgl)=3) THEN ma END)  t3,
        SUM(CASE WHEN (DAY(tgl)=4) THEN ma END)  t4,
        SUM(CASE WHEN (DAY(tgl)=5) THEN ma END)  t5,
        SUM(CASE WHEN (DAY(tgl)=6) THEN ma END)  t6,
        SUM(CASE WHEN (DAY(tgl)=7) THEN ma END)  t7,
        SUM(CASE WHEN (DAY(tgl)=8) THEN ma END)  t8,
        SUM(CASE WHEN (DAY(tgl)=9) THEN ma END)  t9,
        SUM(CASE WHEN (DAY(tgl)=10) THEN ma END) t10,
        SUM(CASE WHEN (DAY(tgl)=11) THEN ma END) t11,
        SUM(CASE WHEN (DAY(tgl)=12) THEN ma END) t12,
        SUM(CASE WHEN (DAY(tgl)=13) THEN ma END) t13,
        SUM(CASE WHEN (DAY(tgl)=14) THEN ma END) t14,
        SUM(CASE WHEN (DAY(tgl)=15) THEN ma END) t15,
        SUM(CASE WHEN (DAY(tgl)=16) THEN ma END) t16,
        SUM(CASE WHEN (DAY(tgl)=17) THEN ma END) t17,
        SUM(CASE WHEN (DAY(tgl)=18) THEN ma END) t18,
        SUM(CASE WHEN (DAY(tgl)=19) THEN ma END) t19,
        SUM(CASE WHEN (DAY(tgl)=20) THEN ma END) t20,
        SUM(CASE WHEN (DAY(tgl)=21) THEN ma END) t21,
        SUM(CASE WHEN (DAY(tgl)=22) THEN ma END) t22,
        SUM(CASE WHEN (DAY(tgl)=23) THEN ma END) t23,
        SUM(CASE WHEN (DAY(tgl)=24) THEN ma END) t24,
        SUM(CASE WHEN (DAY(tgl)=25) THEN ma END) t25,
        SUM(CASE WHEN (DAY(tgl)=26) THEN ma END) t26,
        SUM(CASE WHEN (DAY(tgl)=27) THEN ma END) t27,
        SUM(CASE WHEN (DAY(tgl)=28) THEN ma END) t28,
        SUM(CASE WHEN (DAY(tgl)=29) THEN ma END) t29,
        SUM(CASE WHEN (DAY(tgl)=30) THEN ma END) t30,
        SUM(CASE WHEN (DAY(tgl)=31) THEN ma END) t31
        FROM summ
        GROUP BY gol        
        ";
        $data = collect(DB::select(DB::raw($subquery)));
      
        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('maHarian.index', compact('data', 'site'));
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
