<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopulasiDOController extends Controller
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
            $where1 .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND DEL=0";
            $where2 .= "tp.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND tp.DEL=0";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT a.nom_unit, 
        DATE_FORMAT(DO, \"%d-%m-%Y\") tgl,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), DO)),\"%y\") umur,
        (SELECT FORMAT(hm,1) hm 
        FROM plant_hm 
        WHERE nom_unit=a.nom_unit 
        ORDER BY tgl DESC 
        LIMIT 1) hm,
        FORMAT((DATEDIFF(NOW(), DO) * 24 - b.bd) / (DATEDIFF(NOW(), DO) * 24) * 100,1) MA,
        format(bcm,1) bcm,
        (SELECT namasite FROM site where kodesite=a.kodesite) site
        FROM plant_populasi a
        JOIN (SELECT  nom_unit, SUM(IF(LEFT(aktivitas,1)='B',jam, 0)) bd, SUM(bcm) bcm FROM pma_tp GROUP BY nom_unit) b
        ON a.nom_unit = b.nom_unit
        GROUP BY a.nom_unit
        ORDER BY a.nom_unit";
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
            return view('populasiDO.index', compact('site', 'data'));
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
