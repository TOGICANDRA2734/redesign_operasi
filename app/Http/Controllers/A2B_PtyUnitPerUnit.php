<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class A2B_PtyUnitPerUnit extends Controller
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
            $where .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "WITH summ AS
        (
            SELECT A.nom_unit,
                SUM(IF((A.kode=\"008\"), jam, 0)) wh_8,
                SUM(IF((A.kode=\"009\"), jam, 0)) wh_9,
                SUM(IF((A.kode=\"010\"), jam, 0)) wh_10,
                SUM(IF((A.kode=\"011\"), jam, 0)) wh_11,
                SUM(IF((A.kode=\"012\"), jam, 0)) wh_12,
                SUM(IF(	(A.kode=\"008\") OR
                    (A.kode=\"009\") OR
                    (A.kode=\"010\") OR
                    (A.kode=\"011\") OR
                    (A.kode=\"012\"), jam, 0)) AS wh,
                IF((A.kode=\"008\"), B.prod, 0) bcm_8,
                IF((A.kode=\"009\"), B.prod, 0) bcm_9,
                IF((A.kode=\"010\"), B.prod, 0) bcm_10,
                IF((A.kode=\"011\"), B.prod, 0) bcm_11,
                IF((A.kode=\"012\"), B.prod, 0) bcm_12,
                (B.prod) AS bcm,
                IF((A.kode=\"008\"), B.distbcm, 0) dist_8,
                IF((A.kode=\"009\"), B.distbcm, 0) dist_9,
                IF((A.kode=\"010\"), B.distbcm, 0) dist_10,
                IF((A.kode=\"011\"), B.distbcm, 0) dist_11,
                IF((A.kode=\"012\"), B.distbcm, 0) dist_12,
                (B.distbcm) AS dist
            FROM pma_a2b A
            JOIN (SELECT unit_load, SUM(bcm) AS prod, SUM(distbcm) distbcm, SUM(ritasi) rit FROM pma_tp WHERE ".$where." GROUP BY unit_load) B
            ON A.nom_unit = B.unit_load
            WHERE ".$where."
            GROUP BY nom_unit
        )
        SELECT nom_unit, 
        IFNULL(bcm_8,0) bcm_8,
        IFNULL((bcm_8/wh_8),0) pty_8,
        ifnull((dist_8/bcm_8),0) jarak_8,
        IFNULL(bcm_9,0) bcm_9,
        IFNULL((bcm_9/wh_9),0) pty_9,
        ifnull((dist_9/bcm_9),0) jarak_9,
        IFNULL(bcm_10,0) bcm_10,
        IFNULL((bcm_10/wh_10),0) pty_10,
        ifnull((dist_10/bcm_10),0) jarak_10,
        IFNULL(bcm_11,0) bcm_11,
        IFNULL((bcm_11/wh_11),0) pty_11,
        ifnull((dist_11/bcm_11),0) jarak_11,
        IFNULL(bcm_12,0) bcm_12,
        IFNULL((bcm_12/wh_12),0) pty_12,
        ifnull((dist_12/bcm_12),0) jarak_12,
        IFNULL(bcm,0) bcm,
        IFNULL((bcm/wh),0) pty,
        (dist/bcm) jarak
        FROM summ 
        WHERE bcm !=0 
        GROUP BY nom_unit
        ";
        $data = collect(DB::select(DB::raw($subquery)));

        $judul = ['Loading Ripping', 'Loading Langsung', 'Loading Stock', 'Loading Blasting', 'Loading Mud', 'Total'];

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('A2B_PtyUnitPerUnit.index', compact('data', 'site', 'judul'));
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
