<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(Request $request)
    {
        $where = '';
        $where2 = '';

        if (count($request->all()) > 1) {              
            // Where
            $where .= ($request->has('start') && $request->has('end')) ? "voucher_date BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "wh_code='" . $request->pilihSite . "'" : "";

            // Where
            $where2 .= ($request->has('start') && $request->has('end')) ? "tgl BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where2 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "kodesite='" . $request->pilihSite . "'" : "";
        } else {
            $where .= "voucher_date BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
            $where2 .= "tgl BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "WITH summ AS
        (
        SELECT
        car_no,
        (SUM(IF(
        (LEFT(cat_code,1)='1')OR
        (LEFT(cat_code,1)='2')OR
        (cat_code='901')OR
        (cat_code='902')OR
        (cat_code='90V')OR
        (LEFT(cat_code,2)='98')
        ,price_amt,0))) part_rp,
        
        SUM(IF(cat_code='904',item_qty,0)) solar_ltr,
        SUM(IF(cat_code='904',price_amt,0)) solar_rp,
        SUM(IF(cat_code='903',item_qty,0)) oli_ltr,
        SUM(IF(cat_code='903',price_amt,0)) oli_rp
        
        FROM unit_in_trans
        
        WHERE ".$where."
        
        GROUP BY car_no 
        ORDER BY car_no
        )
        SELECT a.*,IFNULL(b.wh,0) wh
        FROM summ a
        
        LEFT JOIN
        (
        SELECT nom_unit,SUM(IF(LEFT(aktivitas,1)=\"0\",jam,0))wh FROM pma_tp
        WHERE ".$where2."
        GROUP BY nom_unit
        
        UNION ALL
        
        SELECT nom_unit,SUM(IF(LEFT(kode,1)=\"0\",jam,0))wh FROM pma_a2b
        WHERE ".$where2."
        GROUP BY nom_unit
        ) b
        ON a.car_no = b.nom_unit
        
        ORDER BY car_no
        ";
        $data = collect(DB::select(DB::raw($subquery)));

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('cost-part.index', compact('data', 'site'));
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
