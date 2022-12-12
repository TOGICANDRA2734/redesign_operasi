<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TP_PtyUnitPerTipe extends Controller
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
            $where .= "TGL BETWEEN '" . Carbon::now()->startOfYear() . "' AND '" . Carbon::now()->endOfYear() . "'";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "WITH summ AS
        (
            SELECT tgl,
            kode,
            gol_1,
            SUM(IF(aktivitas='001',jam,0)) wh,
            SUM(bcm) bcm,
            SUM(ritasi) rit,
            SUM(distbcm) distbcm
            FROM pma_tp a
            JOIN plant_tipe_unit b
            ON LEFT(a.nom_unit,4) = b.kode
            WHERE ".$where."
            GROUP BY LEFT(a.nom_unit, 4), MONTH(tgl)
        )
        SELECT kode,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 1 THEN IFNULL((bcm/wh),0) END),1),0) jan,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 2 THEN IFNULL((bcm/wh),0) END),1),0) feb,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 3 THEN IFNULL((bcm/wh),0) END),1),0) mar,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 4 THEN IFNULL((bcm/wh),0) END),1),0) apr,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 5 THEN IFNULL((bcm/wh),0) END),1),0) may,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 6 THEN IFNULL((bcm/wh),0) END),1),0) jun,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 7 THEN IFNULL((bcm/wh),0) END),1),0) jul,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 8 THEN IFNULL((bcm/wh),0) END),1),0) aug,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 9 THEN IFNULL((bcm/wh),0) END),1),0) sept,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 10 THEN IFNULL((bcm/wh),0) END),1),0) okt,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 11 THEN IFNULL((bcm/wh),0) END),1),0) nov,
        IFNULL(FORMAT(SUM(CASE WHEN MONTH(tgl) = 12 THEN IFNULL((bcm/wh),0) END),1),0) des
        FROM summ 
        WHERE bcm !=0 
        GROUP BY kode        
        ";
        $data = collect(DB::select(DB::raw($subquery)));

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('TP_PtyUnitPerTipe.index', compact('data', 'site'));
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
