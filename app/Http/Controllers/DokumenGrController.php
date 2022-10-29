<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokumenGrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = "";

        if (count($request->all()) > 1) {              
            // WhereTP
            $where .= ($request->has('nomor')) ? "WHERE no_gr= '" . $request->nomor . "' OR subject_gr LIKE '%" . $request->nomor. "%' " : "";
            $where .= ($request->has('site') && !empty($request->site)) ? " AND " : "";
            $where .= ($request->has('site') && !empty($request->site)) ? "a.kodesite='" . $request->site . "'" : "";
            $where .= ($request->has('status') && !empty($request->status)) ? " AND " : "";
            $where .= ($request->has('status') && !empty($request->status)) ? "a.status=".$request->status." " : "";
        }
  
        // Filter
        $subquery = "SELECT b.namasite site, no_gr, DATE_FORMAT(tgl_gr, \"%d\/%m\/%Y\") tgl_gr, subject_gr, chk_ttd1, chk_ttd2, chk_ttd3, chk_ttd4, chk_ttd5, a.status status
        FROM dokumen_gr a
        JOIN site b
        ON a.kodesite=b.kodesite
        ".$where."
        ORDER BY a.kodesite, no_gr, a.status
        LIMIT 50";

        // Parameter 
        $site = Site::where('status', 1)->get();

        // Data
        $data = collect(DB::select(DB::raw($subquery)));
        
        if(count($request->all()) > 1){
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('dokumen.index', compact('data', 'site'));
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
