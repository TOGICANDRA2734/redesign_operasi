<?php

namespace App\Imports;

use App\Models\ProductivityCoal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductivityCoalImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProductivityCoal([
            'jam' => $row['jam'],
            'rit' => $row['rit'],
            'ket' => strtoupper($row['ket']),
            'pit' => strtoupper($row['pit']),
            'tgl' => Carbon::now()->format('Y-m-d'),
            'admin' => Auth::user()->username,
            'time_admin' => Carbon::now(),
            'kodesite' => Auth::user()->kodesite,
        ]);
    }
}
