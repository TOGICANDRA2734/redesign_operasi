<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MPStatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTotal = DB::select(DB::raw('SELECT COUNT(id) jumlah, FORMAT(COUNT(id)/COUNT(id)*100,1) Persentase FROM mp_biodata WHERE del=1'));
        $dataStatusKaryawan = DB::select("SELECT IF(sttpegawai<>'',sttpegawai,'NA') sttpegawai, COUNT(sttpegawai) jumlah, FORMAT(COUNT(sttpegawai)/(SELECT COUNT(ID) FROM MP_BIODATA WHERE DEL=1) * 100, 1) persentase FROM mp_biodata WHERE del=1 GROUP BY sttpegawai ORDER BY sttpegawai desc");
        $dataKelamin = DB::select(DB::raw("SELECT kelamin, COUNT(kelamin) total, FORMAT(COUNT(kelamin)/(SELECT COUNT(ID) FROM MP_BIODATA WHERE DEL=1) * 100, 1) persentase FROM mp_biodata WHERE del=1 AND (kelamin='PRIA' OR kelamin='WANITA') GROUP BY kelamin"));
        $dataUsia = DB::select(DB::raw("SELECT SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) < 20,1,0)) umur_20,
        SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) >= 20 AND (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) < 30,1,0)) umur_30,
        SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) >= 31 AND (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) <= 40,1,0)) umur_40,
        SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) >= 41 AND (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) <= 50,1,0)) umur_50,
        SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) >= 51 AND (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) <= 60,1,0)) umur_60,
        SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0) >= 61,1,0)) umur_70
        FROM mp_biodata WHERE DEL=1"));
        $dataJabatan = DB::select(DB::raw("SELECT JABATAN, COUNT(JABATAN) total, FORMAT(COUNT(jabatan)/(SELECT COUNT(ID) FROM MP_bIODATA WHERE DEL=1) * 100,1) PERSENTASE FROM MP_BIODATA WHERE DEL=1 GROUP BY JABATAN"));
        $dataDept = DB::select(DB::raw("SELECT DEPT, COUNT(DEPT) total, FORMAT(COUNT(DEPT)/(SELECT COUNT(ID) FROM MP_bIODATA WHERE DEL=1) * 100,1) PERSENTASE FROM MP_BIODATA WHERE DEL=1 GROUP BY DEPT"));
        $dataKec = DB::select(DB::raw("SELECT KEC, COUNT(KEC), COUNT(KEC)/(SELECT COUNT(ID) FROM MP_bIODATA WHERE DEL=1) * 100 PERSENTASE FROM MP_BIODATA WHERE DEL=1 GROUP BY KEC"));

        $judulDataUsia = ['Dibawah Umur 20', '20 - 30 Tahun', '31 - 40 tahun', '41 - 50 tahun', '51 - 60 tahun', 'Diatas 61 tahun'];

        // Data Chart
        // Data Status Karyawan
        $dataChartStatusKaryawan =[];
        foreach ($dataStatusKaryawan as $key => $value) {
            $dataChartStatusKaryawan['label'][] = $value->sttpegawai;
            $dataChartStatusKaryawan['data'][] = $value->jumlah;
        }
        $dataChartStatusKaryawan = json_encode($dataChartStatusKaryawan);

        // Data Usia
        $dataChartUsiaKaryawan =[];
        $i = 0;
        foreach ($dataUsia[0] as $key => $value) {
            $dataChartUsiaKaryawan['label'][] = $judulDataUsia[$i];
            $dataChartUsiaKaryawan['data'][] = $value;
            $i++;
        }
        $dataChartUsiaKaryawan = json_encode($dataChartUsiaKaryawan);

        // Data Usia
        $dataChartDept =[];
        foreach ($dataDept as $key => $value) {
            $dataChartDept['label'][] = $value->DEPT;
            $dataChartDept['data'][] = $value->total;
        }
        $dataChartDept = json_encode($dataChartDept);
        
        // Data Kelamin
        $dataChartKelamin =[];
        foreach ($dataKelamin as $key => $value) {
            $dataChartKelamin['label'][] = $value->kelamin;
            $dataChartKelamin['data'][] = $value->total;
        }
        $dataChartKelamin = json_encode($dataChartKelamin);

        return view('mpStatistik.index', compact('dataTotal', 'dataStatusKaryawan', 'dataKelamin', 'dataUsia', 'dataJabatan', 'dataDept', 'dataKec', 'judulDataUsia', 'dataChartStatusKaryawan', 'dataChartUsiaKaryawan', 'dataChartDept', 'dataChartKelamin'));
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
