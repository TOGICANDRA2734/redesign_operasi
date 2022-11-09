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
        $where1 = '';
        $where2 = '';

        if (count($request->all()) > 1) {              
            // Where 1
            $where1 .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where1 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where1 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "kodesite='" . $request->pilihSite . "'" : "";
            $where1 .= " AND DEL=0";

            // Where 2
            $where2 .= ($request->has('start') && $request->has('end')) ? "a.TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where2 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "a.kodesite='" . $request->pilihSite . "'" : "";
            $where2 .= " AND a.DEL=0";
        } else {
            $where1 .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND DEL=0";
            $where2 .= "a.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND a.DEL=0";
        }

        $site = Site::where('status_website', 1)->get();
        $subquery = "SELECT DATE_FORMAT(a.tgl, \"%d-%m-%Y\") tgl_format,
        DATE_FORMAT(a.tgl, \"%a\") hari,
        IFNULL(b.ob,0) ob_plan,
        IFNULL(SUM(a.bcm),0) ob_act,
        IFNULL(SUM(a.bcm)/b.ob* 100,0) ob_ach,
        IFNULL(b.coal,0) coal_plan,
        IFNULL(c.coal,0) coal_act,
        IFNULL(c.coal/b.coal* 100,0) coal_ach
        FROM pma_tp A
        LEFT JOIN (SELECT SUM(coal) coal, tgl  FROM pma_dailyprod_tc WHERE ".$where1." GROUP BY TGL) C ON C.tgl=A.tgl
        LEFT JOIN (SELECT SUM(ob) ob, sum(coal) coal, tgl FROM pma_dailyprod_plan WHERE ".$where1." GROUP BY TGL) B ON B.tgl=A.tgl
        WHERE ".$where2."
        GROUP BY A.tgl
        ORDER BY YEAR(a.tgl), MONTH(a.tgl), DAY(a.tgl)";
        $data = collect(DB::select($subquery));

        // TODO collect all the data for total OB, coal, ach
        $total = ['ob_plan' => $data->sum('ob_plan'), 'ob_act' => $data->sum('ob_act'), 'ob_ach' => $data->sum('ob_ach'), 'coal_plan' => $data->sum('coal_plan'), 'coal_act' => $data->sum('coal_act'), 'coal_ach' => $data->sum('coal_ach')];

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            $response['total'] = $total;
            return response()->json($response);
        } else {
            return view('daily-production.index', compact('site', 'data', 'total'));
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
