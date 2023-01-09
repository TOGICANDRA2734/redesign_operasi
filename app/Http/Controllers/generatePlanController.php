<?php

namespace App\Http\Controllers;

use App\Models\dataPlan;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class generatePlanController extends Controller
{
    public function index(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'start' => 'required|before_or_equal:end',
            'end' => 'required|after:date',
        ]);

        $begin = new DateTime($request->start);
        $end = new DateTime($request->end);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end->modify('+1 day'));

        $data=collect([]);

        $site = DB::table("site")->select(DB::raw('namasite, kodesite'))->where('status_website', '=', 1)->get();
        // $pit = DB::table("pma_dailyprod_pit")->select(DB::raw('DISTINCT ket'))->where('status','=',1)->get();

        foreach($period  as $key => $dt){
            foreach ($site as $st) {
                $pit = DB::table("pma_dailyprod_pit")->select(DB::raw('DISTINCT ket'))->where('kodesite', '=', $st->kodesite)->where('status','=',1)->get();
                
                foreach($pit as $p){
                    $record = dataPlan::create([
                        'tgl'       => Carbon::parse($dt)->format('Y-m-d'),
                        'pit'       => $p->ket,
                        'ob'        => 0, 
                        'coal'      => 0,
                        'kodesite'  => $st->kodesite,
                    ]);
                }
            }
        }
        
        if($record){
            return redirect()->route('data-prod.report')->with(['success' => 'Data Template Berhasil Ditambahkan!']);
        }
        else{
            return redirect()->route('data-prod.report')->with(['error' => 'Data Template Gagal Ditambahkan!']);
        }
    }
}
