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

        if (count($request->all()) > 1) {              
            // Where
            $where .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "kodesite='" . $request->pilihSite . "'" : "";
        } else {
            // $where .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
            $where .= "tgl BETWEEN '2022-01-01' AND '2022-01-31'";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "WITH summ AS
        (
        SELECT
        nom_unit,
        partdesc,
        (SUM(IF(
        (LEFT(catno,1)='1')OR
        (LEFT(catno,1)='2')OR
        (catno='901')OR
        (catno='902')OR
        (catno='90V')OR
        (LEFT(catno,2)='98')
        ,price_amt,0))) part_rp,
        
        SUM(IF(catno=904,qtyord,0)) solar_ltr,
        SUM(IF(catno=904,price_amt,0)) solar_rp,
        SUM(IF(catno=903,qtyord,0)) oli_ltr,
        SUM(IF(catno=903,price_amt,0)) oli_rp
        
        FROM cost
        
        WHERE ".$where."
        
        GROUP BY nom_unit 
        ORDER BY nom_unit
        )
        SELECT a.*,IFNULL(b.wh,0) wh
        FROM summ a
        
        LEFT JOIN
        (
        SELECT nom_unit,SUM(IF(LEFT(aktivitas,1)=\"0\",jam,0))wh FROM pma_tp
        WHERE ".$where."
        GROUP BY nom_unit
        
        UNION ALL
        
        SELECT nom_unit,SUM(IF(LEFT(kode,1)=\"0\",jam,0))wh FROM pma_a2b
        WHERE ".$where."
        GROUP BY nom_unit
        ) b
        ON a.nom_unit = b.nom_unit
        
        ORDER BY nom_unit
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
