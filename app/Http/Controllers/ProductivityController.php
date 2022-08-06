<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data Detail PTY
        $subquery = "SELECT                                                           
        b.namasite,
        nom_unit,
        AVG(pty) avg_pty,                                                        
        IFNULL(SUM(CASE WHEN jam = 7 THEN pty END),0) j1,                    
        IFNULL(SUM(CASE WHEN jam = 8 THEN pty END),0) j2,                          
        IFNULL(SUM(CASE WHEN jam = 9 THEN pty END),0) j3,                    
        IFNULL(SUM(CASE WHEN jam = 10 THEN pty END),0) j4,                          
        IFNULL(SUM(CASE WHEN jam = 11 THEN pty END),0) j5,                    
        IFNULL(SUM(CASE WHEN jam = 12 THEN pty END),0) j6,                          
        IFNULL(SUM(CASE WHEN jam = 13 THEN pty END),0) j7,                    
        IFNULL(SUM(CASE WHEN jam = 14 THEN pty END),0) j8,                          
        IFNULL(SUM(CASE WHEN jam = 15 THEN pty END),0) j9,                    
        IFNULL(SUM(CASE WHEN jam = 16 THEN pty END),0) j10,                          
        IFNULL(SUM(CASE WHEN jam = 17 THEN pty END),0) j11,                    
        IFNULL(SUM(CASE WHEN jam = 18 THEN pty END),0) j12,                          
        IFNULL(SUM(CASE WHEN jam = 19 THEN pty END),0) j13,                          
        dist,
        ket                    
        FROM pma_dailyprod_pty A 
        JOIN site B
        ON A.kodesite = B.kodesite                                         
        WHERE tgl=CURDATE() AND del=0
        GROUP BY a.kodesite, nom_unit,TYPE
        ORDER BY b.id, nom_unit";

        $dataPty = collect(DB::select($subquery));

        return view('productivity.index', compact('dataPty'));
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
