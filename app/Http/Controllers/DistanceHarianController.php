<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistanceHarianController extends Controller
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

        $subquery = "SELECT DATE_FORMAT(tgl, \"%d-%m-%Y\") tgl, 
        SUM(distbcm) jarak,
        SUM(bcm) ob,
        (SUM(distbcm) / SUM(bcm)) dist_bcm,
        (SELECT namasite FROM site WHERE kodesite=pma_tp.kodesite) site
        FROM pma_tp
        WHERE ".$where."
        GROUP BY tgl, kodesite
        ORDER BY kodesite, tgl
        ";
        $data = collect(DB::select(DB::raw($subquery)));

        $total = [
            'dist' => number_format($data->sum('jarak'),0),
            'prod' => number_format($data->sum('ob'),0),
            'dist_prod' => number_format($data->sum('jarak') / $data->sum('ob'),0),
        ];

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            $response['total'] = $total;
            return response()->json($response);
        } else {
            return view('distance-harian.index', compact('data', 'site', 'total'));
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
