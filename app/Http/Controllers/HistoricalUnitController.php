<?php

namespace App\Http\Controllers;

use App\Models\Plant_Populasi;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subquery = "SELECT a.nom_unit, type_unit, hm
        FROM plant_populasi a
        JOIN plant_hm b
        on a.nom_unit=b.nom_unit";
        $data = collect(DB::select($subquery));

        $site = Site::where('status', 1)->get();

        return view('historical-unit.index', compact('data', 'site'));
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
        $id = Plant_Populasi::where('nom_unit', $id)->get()->pluck('id');
        $data = Plant_Populasi::findOrFail($id);
        $site = Site::where('status', 1)->get();

        // Data
        $subquery = "SELECT a.sn,
            descript,
            CASE WHEN b.status=1 THEN 'RS'
            WHEN b.STATUS=6 THEN 'SR'
            END 'SR/RS', 
            b.hm, 
            DATE_FORMAT(b.tgdok, '%d-%m-%Y') tanggal,
            mechanic,
            c.namasite
            FROM plant_populasi a
            JOIN unit_rssp b
            ON a.nom_unit = b.nom_unit
            JOIN site c
            ON b.kodesite = c.kodesite
            WHERE a.nom_unit='" . $data[0]->nom_unit . "'
            ORDER BY b.tgdok";

        $data = DB::select($subquery);

        return view('historical-unit.show', compact('data', 'site'));
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
