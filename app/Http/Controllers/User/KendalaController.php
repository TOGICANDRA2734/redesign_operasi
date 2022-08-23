<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kendala;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KendalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $bulan = Carbon::now();
        $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";
        $tanggalKedua =  "A.TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";

        /**
         * Kendala
         */
        $subquery = "SELECT *
        FROM pma_dailyprod_kendala
        WHERE ".$tanggal." AND
        kodesite='".Auth::user()->kodesite."'";

        $kendala = collect(DB::select($subquery));

        $site = DB::table('site')->select('namasite')->where('kodesite', '=', Auth::user()->kodesite)->get();

        return view('user.kendala.index', compact('kendala', 'site'));
    }
}
