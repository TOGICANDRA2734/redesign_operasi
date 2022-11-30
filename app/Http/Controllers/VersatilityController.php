<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VersatilityController extends Controller
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

        $subquery = "SELECT nama,
        nik,
        grade,
        D375,
        D155,
        D85,
        PC1250,
        CE6015,
        PC400,
        R480LC,
        HD_785,
        775_F,
        A40_G,
        MR_4040,
        MR_3939,
        LG_DW_90,
        DM_45,
        D245_S,
        WOLF,
        GD_825,
        GD_755,
        GD_705,
        14_M,
        SEM_921,
        G_425,
        SD_100_D,
        SAKAI,
        611_E,
        PC_200,
        PC_210,
        PC_300,
        966_H,
        WA_380_6
        FROM pma_versatility";
        $data = collect(DB::select($subquery));

        if (count($request->all()) > 1) {              
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('versatility.index', compact('site', 'data'));
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
