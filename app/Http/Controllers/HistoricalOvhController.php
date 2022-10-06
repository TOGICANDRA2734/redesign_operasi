<?php

namespace App\Http\Controllers;

use App\Models\PlantOvh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalOvhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('plant_ovh')->select('*')->limit(250)->get();
        $subquery = "SELECT DISTINCT komponen FROM plant_ovh ORDER BY komponen";
        $komponen = collect(DB::select(DB::raw($subquery)));
        return view('historical-overhaul.index', compact('data', 'komponen'));
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

    public function showFilter(Request $request)
    {
        $where = '';
        
        if(count($request->all()) > 1){
            $where .= "WHERE ";
            $where .= ($request->has('pilihKomponen') && !empty($request->pilihKomponen)) ? "komponen='" . $request->pilihKomponen . "'" : "";
            $where .= ($request->has('cariNama') && !empty($request->cariNama)) ? " AND " : "";
            $where .= ($request->has('cariNama') && !empty($request->cariNama)) ? "nom_unit='" . $request->cariNama . "'" : "";
            $where .= "AND DEL=0";    
        }
        
        $subquery = "SELECT *
        FROM plant_ovh
        ".$where."
        ORDER BY nom_unit, model";

        $data = collect(DB::select($subquery));

        $response['data'] = $data;
        return response()->json($response);
        
    }
}
