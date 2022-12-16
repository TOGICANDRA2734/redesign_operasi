<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolarInTransController extends Controller
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
            // $where1 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            // $where1 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "kodesite='" . $request->kodesite . "'" : "";
            $where1 .= " AND del=0";

            // Where 2
            $where2 .= ($request->has('start') && $request->has('end')) ? "a.TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where2 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "a.kodesite='" . $request->kodesite . "'" : "";
            $where2 .= " AND a.del=0";
            
            // Where 3
            $where3 .= ($request->has('start') && $request->has('end')) ? "e.TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where3 .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where3 .= ($request->has('kodesite') && !empty($request->kodesite)) ? "e.kodesite='" . $request->kodesite . "'" : "";
            $where3 .= " AND e.del=0";
        } else {
            $where1 .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND del=0";
            $where2 .= "a.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND a.del=0";
            $where3 .= "e.TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND e.del=0";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT
        DATE_FORMAT(voucher_date, \"%d-%m-%Y\") voucher_date,
        FORMAT(SUM(item_qty),0) item_qty,
        IFNULL((SELECT namasite from site where kodesite=unit_in_trans.wh_code), WH_CODE) wh_code
        FROM unit_in_trans
        WHERE voucher_date BETWEEN '2022-12-01' AND '2022-12-31' 
        GROUP BY voucher_date
        ";
        $data = collect(DB::select(DB::raw($subquery)));

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('fuel-in-trans.index', compact('data', 'site'));
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
