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
        $where1 = '';
        $where2 = '';
        $where3 = '';

        if (count($request->all()) > 1) {              
            // Where 1
            $where1 .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where1 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where1 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "kodesite='" . $request->pilihSite . "'" : "";

            // Where 2
            $where2 .= ($request->has('start') && $request->has('end')) ? "a.TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where2 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "a.kodesite='" . $request->pilihSite . "'" : "";
            
            // Where 3
            $where3 .= ($request->has('start') && $request->has('end')) ? "e.TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where3 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where3 .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "e.kodesite='" . $request->pilihSite . "'" : "";
        } else {
            $where1 .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
            $where2 .= "a.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
            $where3 .= "e.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT tgl, 
        SUM(bcm),
        FORMAT(SUM(distbcm)/SUM(bcm),0) jarak
        FROM PMA_TP
        GROUP BY tgl";
        $data = collect(DB::select(DB::raw($subquery)));

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('distance-harian.index', compact('data', 'site'));
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
