<?php

namespace App\Imports;

use App\Models\Cuaca;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CuacaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Cuaca([
            'cuaca' => $row['cuaca'],
            'tgl' => Carbon::now(),
            'jam' => $row['jam'],
            'kodesite' => Auth::user()->kodesite,
        ]);
    }
}
