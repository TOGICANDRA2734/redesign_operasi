<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthlyProductionController extends Controller
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
            
            // $where1 .= "TGL BETWEEN '2022-09-01' AND '2022-09-31' and kodesite='g' AND DEL=0 ";
            // $where2 .= "a.TGL BETWEEN '2022-09-01' AND '2022-09-31' AND a.DEL=0";

            $where1 .= "TGL BETWEEN '" . Carbon::now()->startOfYear() . "' AND '" . Carbon::now()->endOfYear() . "' AND DEL=0";
            $where2 .= "a.TGL BETWEEN '" . Carbon::now()->startOfYear() . "' AND '" . Carbon::now()->endOfYear() . "' AND a.DEL=0";
        }

        $site = Site::where('status_website', 1)->get();

        // Data OB 
        $subquery = "SELECT d.namasite namasite,
        DATE_FORMAT(a.tgl, '%b, %Y') periode, 
        ifnull(SUM(a.ob),0) budget_ob, 
        ifnull(b.ob,0) joint_survey_ob,
        ifnull(FORMAT((b.ob/SUM(a.ob)) * 100,1),0) ach_js_ob,
        ifnull(c.ob,0) invoice_ob,
        ifnull(FORMAT((c.ob/SUM(a.ob)) * 100,1),0) ach_inv_ob,
        ifnull(SUM(a.coal),0) budget_coal, 
        ifnull(b.coal,0) joint_survey_coal,
        ifnull(FORMAT(b.coal/SUM(a.coal) * 100,1),0) ach_js_coal,
        ifnull(c.coal,0) invoice_coal,
        ifnull(FORMAT(c.coal/SUM(a.coal) * 100,1),0) ach_inv_coal
        FROM pma_budget a
        JOIN (SELECT tgl, kodesite, SUM(ob) ob, SUM(coal) coal FROM pma_joint_survey WHERE ".$where1." GROUP BY tgl, kodesite) b 
        ON a.kodesite=b.kodesite AND a.tgl=b.tgl
        JOIN (SELECT tgl, kodesite, SUM(ob) ob, SUM(coal) coal FROM pma_invoice WHERE ".$where1." GROUP BY tgl, kodesite) c 
        ON a.kodesite=c.kodesite AND a.tgl=c.tgl
        JOIN (SELECT namasite, kodesite FROM site) d
        ON a.kodesite=d.kodesite
        WHERE ".$where2."
        GROUP BY a.kodesite, a.tgl";
        $data = collect(DB::select($subquery));

        // Data WH Efektif
        $subquery = "SELECT *
        FROM PMA_SETTING_TIME 
        WHERE ".$where1."
        ";
        $wh = collect(DB::select($subquery));

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('monthly-production.index', compact('site', 'data'));
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
