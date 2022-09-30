<?php

namespace App\Imports;

use App\Models\Productivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductivityImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Productivity([
            'nom_unit' => $row['nom_unit'],
            'pit' => $row['pit'],
            'pty' => $row['productivity'],
            'dist' => $row['jarak'],
            'ket' => $row['keterangan'],
            'jam' => $row['jam'],
            'tgl' => Carbon::now(),
            'type' => substr($row['nom_unit'], 0, 4),
            'kodesite' => Auth::user()->kodesite,
            'admin' => Auth::user()->username,
            'time_admin' => Carbon::now() 
        ]);
    }
}
