<?php

namespace App\Imports;

use App\Models\Kendala;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KendalaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kendala([
            'shift' => $row['shift'],
            'awal' => $row['awal'],
            'akhir' => $row['akhir'],
            'unit' => $row['unit'],
            'ket' => $row['ket'],
            'tgl' => Carbon::now()->format('Y-m-d'),
            'kodesite' => Auth::user()->kodesite,
        ]);
    }
}
