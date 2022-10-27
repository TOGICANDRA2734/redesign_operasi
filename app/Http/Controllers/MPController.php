<?php

namespace App\Http\Controllers;

use App\Models\Manpower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subquery = "SELECT id,site, nik, nama, dept, jabatan, hpkary, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), '%Y') + 0 tgllahir, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),mulaikerja)), '%Y') + 0 mulaikerja, 
        FORMAT(((
            (IF(nik<>'',1,0)) +
            (IF(nama<>'',1,0)) +
            (IF(tempatlahir<>'',1,0)) +
            (IF(tgllahir<>'',1,0)) +
            (IF(kelamin<>'',1,0)) +
            (IF(noktp<>'',1,0)) +
            (IF(goldarah<>'',1,0)) +
            (IF(rhesus<>'',1,0)) +
            (IF(agama<>'',1,0)) +
            (IF(warganegara<>'',1,0)) +
            (IF(statusnikah<>'',1,0)) +
            (IF(pendidikan<>'',1,0)) +
            (IF(ibukandung<>'',1,0)) +
            (IF(dept<>'',1,0)) +
            (IF(grade<>'',1,0)) +
            (IF(gol<>'',1,0)) +
            (IF(jabatan<>'',1,0)) +
            (IF(mulaikerja<>'',1,0)) +
            (IF(statuskary<>'',1,0)) +
            (IF(perubahanpkwt<>'',1,0)) +
            (IF(lamakontrak<>'',1,0)) +
            (IF(ppjpkwt<>'',1,0)) +
            (IF(tglpensiun<>'',1,0)) +
            (IF(statuspph<>'',1,0)) +
            (IF(alamatktp<>'',1,0)) +
            (IF(provktp<>'',1,0)) +
            (IF(kabktp<>'',1,0)) +
            (IF(kecktp<>'',1,0)) +
            (IF(kelktp<>'',1,0)) +
            (IF(statusrmh<>'',1,0)) +
            (IF(alamat<>'',1,0)) +
            (IF(prov<>'',1,0)) +
            (IF(kab<>'',1,0)) +
            (IF(kec<>'',1,0)) +
            (IF(kel<>'',1,0)) +
            (IF(nosimpol<>'',1,0)) +
            (IF(typesimpol<>'',1,0)) +
            (IF(masasimpol<>'',1,0)) +
            (IF(nokk<>'',1,0)) +
            (IF(nonpwp<>'',1,0)) +
            (IF(norek<>'',1,0)) +
            (IF(nobpjstk<>'',1,0)) +
            (IF(nobpjskes<>'',1,0)) +
            (IF(namaistri<>'',1,0)) +
            (IF(namaanak1<>'',1,0)) +
            (IF(namaanak2<>'',1,0)) +
            (IF(namaanak3<>'',1,0)) +
            (IF(hpkary<>'',1,0)) +
            (IF(emailkary<>'',1,0)) +
            (IF(tlpserumah<>'',1,0)) +
            (IF(hubkel<>'',1,0)) +
            (IF(telptakrmh<>'',1,0)) +
            (IF(hubkel<>'',1,0)) +
            (IF(sertifikasi<>'',1,0)) +
            (IF(vaksin1<>'',1,0)) +
            (IF(vaksin2<>'',1,0)) +
            (IF(booster<>'',1,0)) +
            (IF(keterangan<>'',1,0)) +
            (IF(user<>'',1,0)) +
            (IF(time<>'',1,0)) +
            (IF(idapp<>'',1,0)) +
            (IF(site<>'',1,0)) +
            (IF(kodesite<>'',1,0)) +
            (IF(foto1<>'',1,0)) +
            (IF(foto2<>'',1,0)) +
            (IF(ktp<>'',1,0)) +
            (IF(sttpegawai<>'',1,0)) +
            (IF(sttkeluarga<>'',1,0)) +
            (IF(akhirpkwt<>'',1,0)) +
            (IF(faskes<>'',1,0))
        ) / (SELECT count(*) AS NUMBEROFCOLUMNS FROM information_schema.columns where table_name='mp_biodata') * 100 ), 1) lengkap        
        FROM mp_biodata
        LIMIT 100";
        $data = DB::select(DB::raw($subquery));
        return view('mp.index', compact('data'));
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
        $record1 = Manpower::select(DB::raw('nik, nama, tempatlahir, tgllahir, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgllahir)), \'%Y\') + 0 Umur, agama, warganegara, pendidikan, gol, ibukandung,  statusnikah, sttkeluarga, kelamin, rhesus, noktp, nokk, nonpwp, nobpjstk, nobpjskes, norek, nosimpol, typesimpol, masasimpol, faskes, alamatktp, provktp, kabktp, kecktp, kelktp, alamat, prov, kab, kec, kel'))->where('id', $id)->get();
        $record2 = Manpower::select(DB::raw('dept, sttpegawai, jabatan,  vaksin1, gol, grade, statuskary, mulaikerja, akhirpkwt, tglpensiun, emailkary, namaistri, namaanak1, namaanak2, namaanak3, tlpserumah, hubkel, telptakrmh, hubkel2, keterangan'))->where('id', $id)->get();
        $record3 = Manpower::select(DB::raw('foto1, foto2, ktp'))->where('id', $id)->get();
        
        $data['record1'] = $record1;
        $data['record2'] = $record2;
        $data['record3'] = $record3;
        

        $data['judulrecord1'] = ['NIK', 'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'Umur', 'Agama', 'Warga Negara', 'Pendidikan', 'Gol. Darah', 'Nama Ibu',  'Status', 'Status Keluarga', 'Jenis Kelamin', 'Rhesus', 'No. KTP', 'No. KK', 'No. NPWP', 'No. BPJSTK', 'No. BPJSKES', 'No. Rek', 'No. Simpol', 'Tipe Simpol', 'Masa Simpol', 'Faskes', 'Alamat KTP', 'Provinsi KTP', 'Kabupaten KTP', 'Kecamatan KTP', 'Kelurahan KTP', 'Alamat', 'Provinsi', 'Kabupaten ', 'Kecamatan', 'Kelurahan'];
        $data['judulrecord2'] = ['Departemen', 'Status Pegawai', 'Jabatan',  'Vaksin 1', 'Golongan Karyawan', 'Grade', 'Status Karyawan', 'Mulai Kerja', 'Akhir PKWT', 'Tanggal Pensiun', 'Email Karyawan', 'Nama Istri', 'Nama Anak 1', 'Nama Anak 2', 'Nama Anak 3', 'Telepon Rumah', 'Hubungan Keluarga', 'Telepon Rumah', 'Hubungan Keluarga 2', 'Keterangan'];
        $data['judulrecord3'] = ['foto1', 'foto2', 'ktp'];
        return response()->json($data);
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
