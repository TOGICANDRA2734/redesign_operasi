<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolarOpnameController extends Controller
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
            // Where 1
            $where .= ($request->has('start') && $request->has('end')) ? "voucher_date BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where .= ($request->has('kodesite') && !empty($request->kodesite)) ? " AND " : "";
            $where .= ($request->has('kodesite') && !empty($request->kodesite)) ? "wh_code='" . $request->kodesite . "'" : "";
            $where .= " AND cat_code=\"904\" AND del=0";
        } else {
            $where .= "voucher_date BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND cat_code=\"904\" AND del=0";
        }

        $site = Site::where('status_website', 1)->get();

        $subquery = "SELECT car_no,
        SUM(IF((cat_code=\"904\" AND car_no=\"STOCK\"), item_qty,0)) solar_stock, 
        SUM(IF((cat_code=\"904\" AND car_no<>\"STOCK\"), item_qty,0)) solar_non_stock
        FROM unit_in_trans
        WHERE ".$where."
        GROUP BY car_no
        ORDER BY car_no
        ";
        $data = collect(DB::select(DB::raw($subquery)));
        $total = [
            'total_stock' => $data->sum('solar_stock'),
            'total_non_stock' => $data->sum('solar_non_stock'),
            'stock' => $data->sum('solar_stock') - $data->sum('solar_non_stock'),
        ];

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            $response['total'] = $total;
            return response()->json($response);
        } else {
            return view('fuel-opname.index', compact('data', 'site', 'total'));
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
