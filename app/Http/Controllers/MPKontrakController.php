<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MPKontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subquery = "SELECT id, site, nik, nama, dept, jabatan, statuskary, DATE_FORMAT(tgllahir, \"%d-%m-%Y\") tgllahir, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0 umur, DATE_FORMAT(mulaikerja, \"%d-%m-%Y\") mulaikerja, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),mulaikerja)), '%Y') + 0 masa_kerja, DATE_FORMAT(tglpensiun, \"%d-%m-%Y\") tglpensiun, akhirpkwt, keterangan, IF(akhirpkwt < NOW(), \"Kontrak Habis\", (IF(akhirpkwt >= NOW() + INTERVAL 1 MONTH, \"Dibawah Kontrak\", \"Kontrak Habis dalam 1 Bulan\"))) skpkwt, IF(tglpensiun < NOW(), \"Pensiun\", (IF(tglpensiun >= NOW() + INTERVAL 6 MONTH, \"Belum Pensiun\", \"Segera Pensiun\"))) skpensiun 
        FROM mp_biodata_local";
        $data = DB::select(DB::raw($subquery));
        return view('mpKontrak.index', compact('data'));
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
