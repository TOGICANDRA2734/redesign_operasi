<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kendala;
use App\Models\Site;
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
    public function index(Request $request)
    {
        if ($request->has('pilihBulan')) {
            $bulan = Carbon::createFromFormat('Y-m', request()->pilihBulan);
            $tanggal =  "tgl BETWEEN '" . date('Y-m-d', strtotime($bulan->startOfMonth()->copy())) . "' AND '" . date('Y-m-d', strtotime($bulan->endOfMonth()->copy())) . "'";
        } else {
            $bulan = Carbon::now();
            $tanggal =  "tgl=CURDATE()";
        }

        if ($request->has('kodesite') && $request->kodesite !== 'all') {
            $subquery = "SELECT *
            FROM pma_dailyprod_kendala
            WHERE ".$tanggal." AND kodesite='".$request->kodesite."' 
            ORDER BY tgl DESC";
        } else {
            $subquery = "SELECT *
            FROM pma_dailyprod_kendala
            WHERE ".$tanggal."
            ORDER BY tgl DESC";
        }

        $data = collect(DB::select($subquery));

        $site = Site::where('status_website', 1)->get();

        if  ($request->has('kodesite') || $request->has('pilihBulan')) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('kendala.index', compact('data', 'site'));
        }
    }
}
