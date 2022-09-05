<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalUnitController extends Controller
{
    public function index()
    {
        $subquery = "SELECT a.nom_unit, type_unit, hm, ket_tgl_rfu
        FROM plant_populasi a
        JOIN plant_status_bd b
        ON a.nom_unit = b.nom_unit";
        $data = collect(DB::select($subquery));

        $site = Site::where('status',1)->get();

        return view('historical-unit.index', compact('data', 'site'));
    }
}
