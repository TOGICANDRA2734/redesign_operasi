<?php

namespace App\Imports;

use App\Models\Productivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductivityImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Productivity([
            'nom_unit' => $row[1],
            'pit' => $row[2],
            'pty' => $row[3],
            'dist' => $row[4],
            'ket' => $row[5],
            'jam' => $row[6],
            'tgl' => Carbon::now(),
            'type' => substr($row[1], 0, 4),
            'kodesite' => Auth::user()->kodesite,
            'admin' => Auth::user()->name,
            'time_admin' => Carbon::now() 
        ]);
    }
}
