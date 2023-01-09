<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuelDailyController extends Controller
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
            $where2 .= ($request->has('start') && $request->has('end')) ? "tp.TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where2 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "tp.kodesite='" . $request->pilihSite . "'" : "";
            $where2 .= " AND tp.DEL=0";
        } else {
            // $where1 .= "TGL BETWEEN '2022-10-01' AND '2022-10-31' AND DEL=0";
            // $where2 .= "tp.TGL BETWEEN '2022-10-01' AND '2022-10-31' AND tp.DEL=0";

            $where1 .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND DEL=0";
            $where2 .= "tp.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND tp.DEL=0";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT DATE_FORMAT(tp.tgl, \"%d-%m-%Y\") tgl,
        FORMAT(SUM(bcm),2) bcm,
        FORMAT(SUM(IF(LEFT(aktivitas,1)='0', jam, 0)),2) wh,
        FORMAT(SUM(IF(aktivitas='001', jam, 0)),2) jam_ob,
        FORMAT(SUM(IF(aktivitas='003' OR aktivitas='004', jam, 0)),2) jam_coal,
        FORMAT(fuel.qty,2) solar,
        fuel.qty/SUM(IF(LEFT(aktivitas,1)='0', jam, 0)) liter_per_jam,
        SUM(IF(aktivitas='001', jam, 0))  * (fuel.qty/SUM(IF(LEFT(aktivitas,1)='0', jam, 0))) / SUM(bcm) liter_bcm,
        FORMAT(SUM(IF(aktivitas='003' OR aktivitas='004', jam, 0))  * (fuel.qty/SUM(IF(LEFT(aktivitas,1)='0', jam, 0)))/c.coal,2) liter_coal
        FROM pma_tp tp
        JOIN (SELECT SUM(qty) qty, tgl
        FROM pma_fuel 
        WHERE ".$where1."
        GROUP BY tgl) fuel
        ON tp.tgl=fuel.tgl
        JOIN (SELECT SUM(coal) coal, tgl
        FROM pma_dailyprod_plan
        WHERE ".$where1."
        GROUP BY tgl) c
        ON tp.tgl=c.tgl
        WHERE ".$where2."
        GROUP BY tp.tgl";
        $data = collect(DB::select($subquery));
        
        // $totalProduksiOB = $data->sum('bcm');
        // $totalWH = $data->sum('wh');
        // $totalJamOb = $data->sum('jam_ob');
        // $totalJamCoal = $data->sum('jam_coal');
        // $totalSolar = $data->sum('solar');
        // $totalSolarPerJam = $totalSolar / $totalWH;

        if (count($request->all()) > 1) {              
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('fuel-daily.index', compact('site', 'data'));
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
