<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TP_PtyUnitPerUnit extends Controller
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
        SELECT tgl,
        nom_unit,
        SUM(IF(aktivitas='001',jam,0)) wh,
        SUM(bcm) bcm,
        SUM(ritasi) rit,
        SUM(distbcm) distbcm
        FROM pma_tp
        WHERE tgl BETWEEN '2022-01-01' AND '2022-12-31' AND kodesite='i'
        GROUP BY nom_unit, MONTH(tgl)
        )
        SELECT nom_unit,
        SUM(CASE WHEN MONTH(tgl) = 1 THEN IFNULL((bcm/wh),0) END) jan,
        SUM(CASE WHEN MONTH(tgl) = 2 THEN IFNULL((bcm/wh),0) END) feb,
        SUM(CASE WHEN MONTH(tgl) = 3 THEN IFNULL((bcm/wh),0) END) mar,
        SUM(CASE WHEN MONTH(tgl) = 4 THEN IFNULL((bcm/wh),0) END) apr,
        SUM(CASE WHEN MONTH(tgl) = 5 THEN IFNULL((bcm/wh),0) END) may,
        SUM(CASE WHEN MONTH(tgl) = 6 THEN IFNULL((bcm/wh),0) END) jun,
        SUM(CASE WHEN MONTH(tgl) = 7 THEN IFNULL((bcm/wh),0) END) jul,
        SUM(CASE WHEN MONTH(tgl) = 8 THEN IFNULL((bcm/wh),0) END) aug,
        SUM(CASE WHEN MONTH(tgl) = 9 THEN IFNULL((bcm/wh),0) END) sept,
        SUM(CASE WHEN MONTH(tgl) = 10 THEN IFNULL((bcm/wh),0) END) okt,
        SUM(CASE WHEN MONTH(tgl) = 11 THEN IFNULL((bcm/wh),0) END) nov,
        SUM(CASE WHEN MONTH(tgl) = 12 THEN IFNULL((bcm/wh),0) END) des
        FROM summ 
        WHERE bcm !=0 
        GROUP BY nom_unit       
        ";
        $data = collect(DB::select(DB::raw($subquery)));

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('TP_PtyUnitPerUnit.index', compact('data', 'site'));
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
