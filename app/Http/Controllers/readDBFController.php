<?php

namespace App\Http\Controllers;

use App\Models\PmaTp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use XBase\TableReader;

class readDBFController extends Controller
{
    protected int $value;
    
    public function index()
    {
        // TODO: try to learn on how does the dbf work

        $table = new TableReader(storage_path('app\public\RTI2212.dbf'));

        $x = [];

        while ($record = $table->nextRecord()) {    
            // Get All Header Name
            foreach($table->getHeaderName() as $dt){
                $x[]=$dt->name;
            }

            // Value assignment
            $this->value=$table->getRecordCount();

            // Cek Tanggal
            $tgl = substr($record->tgl,0,4) . "-" . substr($record->tgl,4,2) . "-" . substr($record->tgl,6,2);
            $durasi = $this->durasi_jam($record->jam_awal, $record->jam_akhir); 


            // $cekCount = PmaTp::create([
            //     "nom_unit"      => $record->nom_unit,
            //     "tgl"           => Carbon::createFromFormat('Y-m-d', $tgl)->format('Y-m-d'),
            //     "shift"         => $record->shift,
            //     "jam_awal"      => $record->jam_awal,
            //     "jam_akhir"     => $record->jam_akhir,
            //     "ritasi"        => $am_akhir,
            //     "operator"      => $record->operator,
            //     "nama"          => $record->nama,
            //     'haul_dist,'    => 1,
            //     'grade,'        => 1,
            //     'kodeload,'     => 1,
            //     'load_area,'    => 1,
            //     'kodedisp,'     => 1,
            //     'disp_area,' => 1,
            //     'unit_load,' => 1,
            //     'akt_load,'  => 1,
            //     'kaktload,'  => 1,
            //     'material,'  => 1,
            //     'kmaterial,' => 1,
            //     'aktivitas,' => 1,
            //     'kaktivitas,'=> 1,
            //     'recheader,' => 1,
            //     'recno,'     => 1,
            //     'aktopr,'    => 1,
            //     'ketaktopr,' => 1,
            //     'siteno,'    => 1,
            //     'kodesite,'  => 1,
            //     'bcm,'       => 1,
            //     'distbcm,'   => 1,
            //     'jam'=> 1,

            //     "keterangan"    => $record->keterangan,
            //     "kodelok"       => $record->kodelok,
            //     "lokasi"        => $record->lokasi,
            //     "aktopr"        => $record->aktopr,
            //     "ketaktopr"     => $record->ketaktopr,
            //     "material"      => $record->material,
            //     "ktmaterial"    => $record->ktmaterial,
            //     "recno"         => $record->recno,
            //     "recheader"     => $record->recheader,
            //     "siteno"        => $record->siteno,
            // ]);

        }
    }

    public function HitungBCM($noUnit, $Ritasi, $Aktload)
    {
        $n_mud = 0; 
        $mud = 0; 
        $hasil= 0;


        for ($i=0; $i < $this->value; $i++) { 
            if($noUnit == Data)
        }

    }

    public function durasi_jam($jam_awal, $jam_akhir)
    {
        $HAwal = (int) substr($jam_awal, 1, 2)*60; 
        $HAkhir = (int) substr($jam_akhir, 1, 2)*60; 
        $MAwal = (int) substr($jam_awal, 4, 2); 
        $MAkhir = (int) substr($jam_akhir, 4, 2);
        $CAwal = $HAwal + $MAwal;
        $CAkhir = $HAkhir + $MAkhir;
        $selisih = $CAkhir - $CAwal;
        $hitung = $selisih/60;

        if($hitung < 0){
            $hitung = $hitung * -1;
            $hitung = 24 - $hitung;
        }

        $result = (String) $hitung;

        dd($HAwal,
        $HAkhir,
        $MAwal,
        $MAkhir,
        $CAwal,
        $CAkhir,
        $selisih,
        $hitung,
        $result);
    }
}
