<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiCustomerJointSurveyController extends Controller
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
            $where .= ($request->has('cariNama') && !empty($request->cariNama)) ? "unit_load LIKE '%" . $request->cariNama . "%'" : "";
            $where .= " AND del=0";

        } else {
            $where .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
        }


        $site = Site::where('status_website', 1)->get();

        $subquery = "WITH summ AS
        (
            (SELECT 
            \"budget\" kode,
            bulan,
            SUM(ob)ob,
            SUM(coal)coal
            FROM pma_budget
            WHERE ".$where."
            GROUP BY bulan
            ORDER BY bulan)
        
            UNION ALL
        
            (SELECT 
            \"js\" kode,
            bulan,
            SUM(ob)ob,
            SUM(coal)coal
            FROM pma_joint_survey
            WHERE ".$where."
            GROUP BY bulan
            ORDER BY bulan)

            UNION ALL
        
            (SELECT 
            \"customer\" kode,
            bulan,
            SUM(ob)ob,
            SUM(coal)coal
            FROM pma_target_customer
            WHERE ".$where."
            GROUP BY bulan
            ORDER BY bulan)
        )
        
        SELECT COALESCE(bulan, \"SUB TOTAL\") bulan,
        SUM(IF(kode=\"budget\",ob,0)) ob_bud,
        SUM(IF(kode=\"budget\",coal,0)) coal_bud,
        SUM(IF(kode=\"customer\",ob,0)) ob_cust,
        SUM(IF(kode=\"customer\",coal,0)) coal_cust,
        SUM(IF(kode=\"js\",ob,0)) ob_js,
        SUM(IF(kode=\"js\",coal,0)) coal_js,
        (SUM(IF(kode=\"customer\",ob,0))/SUM(IF(kode=\"js\",ob,0))*100) ach_ob,
        (SUM(IF(kode=\"customer\",coal,0))/SUM(IF(kode=\"js\",coal,0))*100) ach_coal
        FROM summ
        GROUP BY bulan  WITH ROLLUP";
        $data = collect(DB::select(DB::raw($subquery)));
      
        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('produksiCustomerJointSurvey.index', compact('data', 'site'));
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
