<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FleetSettingController extends Controller
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

        $subquery = "SELECT DATE_FORMAT(tgl, \"%d-%m-%Y\") tgl, 
        unit_load, 
        nom_unit,
        SUM(bcm) prod,
        (SELECT SUM(IF((kode=\"008\") OR
                  (kode=\"009\") OR
                      (kode=\"010\") OR
                      (kode=\"011\") OR
                      (kode=\"012\"),jam,0)) AS wh 
        FROM pma_a2b 
        WHERE tgl BETWEEN '2022-01-01' AND '2022-01-31' 
        AND nom_unit=pma_tp.unit_load
        AND kodesite=pma_tp.kodesite
        GROUP BY nom_unit
        ) wh,
        SUM(bcm) / (SELECT SUM(IF((kode=\"008\") OR
                  (kode=\"009\") OR
                      (kode=\"010\") OR
                      (kode=\"011\") OR
                      (kode=\"012\"),jam,0)) AS wh 
                FROM pma_a2b 
                WHERE tgl BETWEEN '2022-01-01' AND '2022-01-31' 
                AND nom_unit=pma_tp.unit_load
                AND kodesite=pma_tp.kodesite
                GROUP BY nom_unit
        ) pty_loading
        FROM pma_tp 
        WHERE tgl BETWEEN '2022-01-01' AND '2022-01-31' 
        AND unit_load <> \"\"
        AND akt_load <> \"\"
        AND kodesite = 'q'
        AND bcm!=0
        GROUP BY nom_unit     
        ORDER BY tgl, unit_load, nom_unit
        ";
        $data = collect(DB::select(DB::raw($subquery)));

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('fleet-setting.index', compact('data', 'site'));
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
