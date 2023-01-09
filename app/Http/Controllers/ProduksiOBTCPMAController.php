<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiOBTCPMAController extends Controller
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
            $where1 .= " AND del=0";

            // Where 1
            $where2 .= ($request->has('start') && $request->has('end')) ? "a.tgl BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "a.kodesite='" . $request->kodesite . "'" : "";
            $where2 .= " AND del=0";
        } else {
            $where1 .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
            $where2 .= "a.tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND a.del=0";
        }


        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT
        a.tgl,
        (c.ob) ob_plan,
        (c.coal) coal_plan,
        SUM(a.bcm) ob_tc,
        (b.coal) coal_tc,
        (SUM(a.bcm)/c.ob) ach_ob,
        (b.coal/c.coal) ach_coal
        
        FROM pma_tp a
        
        LEFT JOIN
        (
        SELECT 
        tgl,
        SUM(coal) coal
        FROM pma_dailyprod_tc
        WHERE ".$where1."
        GROUP BY tgl
        ) b
        ON a.tgl = b.tgl
        
        LEFT JOIN
        (
        SELECT 
        tgl,
        SUM(ob) ob, 
        SUM(coal) coal
        FROM pma_dailyprod_plan
        WHERE ".$where1."
        GROUP BY tgl
        ) c
        ON a.tgl = c.tgl
        
        
        WHERE ".$where2."
        GROUP BY a.tgl
        ";
        $data = collect(DB::select(DB::raw($subquery)));
      
        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('produksiInvoiceJointSurvey.index', compact('data', 'site'));
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
