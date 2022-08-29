<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MohhController extends Controller
{
    public function index(Request $request)
    {
        if($request && $request->has('cari_1') || $request->has('cari_2')){
            if($request->has('cari_1')){
                $cari = "nom_unit LIKE '%".$request->cari_1."%' and";                
            } else if($request->has('cari_2')){
                $cari = "nom_unit LIKE '%".$request->cari_2."%' and";                
            }
        } else{
            $cari = "";
        }

        if($request && $request->has('bulan')){
            $bulan = Carbon::parse($request->bulan);
            $awal = $bulan->startOfMonth()->copy();
            $akhir = $bulan->endOfMonth()->copy();

            if(!$request->has('kodesite')){
                $tanggal =  "TGL BETWEEN '" . $awal . "' AND '" . $akhir . "'";              
            } else {
                $tanggal =  "TGL BETWEEN '" . $awal . "' AND '" . $akhir . "' and";              
            }
        } else{
            $bulan = Carbon::now();
            if(!$request->has('kodesite')){
                $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";    
            } else {
                $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "' and";    
            }
        }

        if($request && $request->has('kodesite')){
            $site = "kodesite='".$request->kodesite."'";                
        } else{
            $site = "";
        }

        $subquery = "WITH summ AS                                                     
        (                                                               
        SELECT                                                           
        nom_unit,                                                        
        COUNT(nom_unit) jum,                                             
        round(SUM(CASE WHEN DAY(tgl) = 1 THEN jam END),0) t1,                     
        round(SUM(CASE WHEN DAY(tgl) = 2 THEN jam END),0) t2,                     
        round(SUM(CASE WHEN DAY(tgl) = 3 THEN jam END),0) t3,                     
        round(SUM(CASE WHEN DAY(tgl) = 4 THEN jam END),0) t4,                     
        round(SUM(CASE WHEN DAY(tgl) = 5 THEN jam END),0) t5,                     
        round(SUM(CASE WHEN DAY(tgl) = 6 THEN jam END),0) t6,                     
        round(SUM(CASE WHEN DAY(tgl) = 7 THEN jam END),0) t7,                     
        round(SUM(CASE WHEN DAY(tgl) = 8 THEN jam END),0) t8,                     
        round(SUM(CASE WHEN DAY(tgl) = 9 THEN jam END),0) t9,                     
        round(SUM(CASE WHEN DAY(tgl) = 10 THEN jam END),0) t10,                   
        round(SUM(CASE WHEN DAY(tgl) = 11 THEN jam END),0) t11,                   
        round(SUM(CASE WHEN DAY(tgl) = 12 THEN jam END),0) t12,                   
        round(SUM(CASE WHEN DAY(tgl) = 13 THEN jam END),0) t13,                   
        round(SUM(CASE WHEN DAY(tgl) = 14 THEN jam END),0) t14,                   
        round(SUM(CASE WHEN DAY(tgl) = 15 THEN jam END),0) t15,                   
        round(SUM(CASE WHEN DAY(tgl) = 16 THEN jam END),0) t16,                   
        round(SUM(CASE WHEN DAY(tgl) = 17 THEN jam END),0) t17,                   
        round(SUM(CASE WHEN DAY(tgl) = 18 THEN jam END),0) t18,                   
        round(SUM(CASE WHEN DAY(tgl) = 19 THEN jam END),0) t19,                   
        round(SUM(CASE WHEN DAY(tgl) = 20 THEN jam END),0) t20,                   
        round(SUM(CASE WHEN DAY(tgl) = 21 THEN jam END),0) t21,                   
        round(SUM(CASE WHEN DAY(tgl) = 22 THEN jam END),0) t22,                   
        round(SUM(CASE WHEN DAY(tgl) = 23 THEN jam END),0) t23,                   
        round(SUM(CASE WHEN DAY(tgl) = 24 THEN jam END),0) t24,                   
        round(SUM(CASE WHEN DAY(tgl) = 25 THEN jam END),0) t25,                   
        round(SUM(CASE WHEN DAY(tgl) = 26 THEN jam END),0) t26,                   
        round(SUM(CASE WHEN DAY(tgl) = 27 THEN jam END),0) t27,                   
        round(SUM(CASE WHEN DAY(tgl) = 28 THEN jam END),0) t28,                   
        round(SUM(CASE WHEN DAY(tgl) = 29 THEN jam END),0) t29,                   
        round(SUM(CASE WHEN DAY(tgl) = 30 THEN jam END),0) t30,                   
        round(SUM(CASE WHEN DAY(tgl) = 31 THEN jam END),0) t31,                   
        round(SUM(jam),0) x_total,                                                   
        '2' urut                                                         
        FROM pma_tp                                                       
        WHERE ".$cari." ".$tanggal." ".$site." 
        GROUP BY nom_unit                                                
                                                                         
        UNION ALL                                                        
                                                                         
        SELECT                                                           
        nom_unit,                                                        
        COUNT(nom_unit) jum,                                            
        round(SUM(CASE WHEN DAY(tgl) = 1 THEN jam END),0) t1,                     
        round(SUM(CASE WHEN DAY(tgl) = 2 THEN jam END),0) t2,                     
        round(SUM(CASE WHEN DAY(tgl) = 3 THEN jam END),0) t3,                     
        round(SUM(CASE WHEN DAY(tgl) = 4 THEN jam END),0) t4,                     
        round(SUM(CASE WHEN DAY(tgl) = 5 THEN jam END),0) t5,                     
        round(SUM(CASE WHEN DAY(tgl) = 6 THEN jam END),0) t6,                     
        round(SUM(CASE WHEN DAY(tgl) = 7 THEN jam END),0) t7,                     
        round(SUM(CASE WHEN DAY(tgl) = 8 THEN jam END),0) t8,                     
        round(SUM(CASE WHEN DAY(tgl) = 9 THEN jam END),0) t9,                     
        round(SUM(CASE WHEN DAY(tgl) = 10 THEN jam END),0) t10,                   
        round(SUM(CASE WHEN DAY(tgl) = 11 THEN jam END),0) t11,                   
        round(SUM(CASE WHEN DAY(tgl) = 12 THEN jam END),0) t12,                   
        round(SUM(CASE WHEN DAY(tgl) = 13 THEN jam END),0) t13,                   
        round(SUM(CASE WHEN DAY(tgl) = 14 THEN jam END),0) t14,                   
        round(SUM(CASE WHEN DAY(tgl) = 15 THEN jam END),0) t15,                   
        round(SUM(CASE WHEN DAY(tgl) = 16 THEN jam END),0) t16,                   
        round(SUM(CASE WHEN DAY(tgl) = 17 THEN jam END),0) t17,                   
        round(SUM(CASE WHEN DAY(tgl) = 18 THEN jam END),0) t18,                   
        round(SUM(CASE WHEN DAY(tgl) = 19 THEN jam END),0) t19,                   
        round(SUM(CASE WHEN DAY(tgl) = 20 THEN jam END),0) t20,                   
        round(SUM(CASE WHEN DAY(tgl) = 21 THEN jam END),0) t21,                   
        round(SUM(CASE WHEN DAY(tgl) = 22 THEN jam END),0) t22,                   
        round(SUM(CASE WHEN DAY(tgl) = 23 THEN jam END),0) t23,                   
        round(SUM(CASE WHEN DAY(tgl) = 24 THEN jam END),0) t24,                   
        round(SUM(CASE WHEN DAY(tgl) = 25 THEN jam END),0) t25,                   
        round(SUM(CASE WHEN DAY(tgl) = 26 THEN jam END),0) t26,                   
        round(SUM(CASE WHEN DAY(tgl) = 27 THEN jam END),0) t27,                   
        round(SUM(CASE WHEN DAY(tgl) = 28 THEN jam END),0) t28,                   
        round(SUM(CASE WHEN DAY(tgl) = 29 THEN jam END),0) t29,                   
        round(SUM(CASE WHEN DAY(tgl) = 30 THEN jam END),0) t30,                   
        round(SUM(CASE WHEN DAY(tgl) = 31 THEN jam END),0) t31,                   
        round(SUM(jam),0) x_total,                                                       
        '1' urut                                                         
        FROM pma_a2b                                                      
        WHERE ".$cari." ".$tanggal." ".$site." 
        GROUP BY nom_unit                                                
        )                                                                
        SELECT                                                           
        nom_unit,                                                        
        jum,                                                             
        IFNULL(t1,0) t1,                                                 
        IFNULL(t2,0) t2,                                                 
        IFNULL(t3,0) t3,                                                 
        IFNULL(t4,0) t4,                                                 
        IFNULL(t5,0) t5,                                                 
        IFNULL(t6,0) t6,                                                 
        IFNULL(t7,0) t7,                                                 
        IFNULL(t8,0) t8,                                                 
        IFNULL(t9,0) t9,                                                 
        IFNULL(t10,0) t10,                                               
        IFNULL(t11,0) t11,                                               
        IFNULL(t12,0) t12,                                               
        IFNULL(t13,0) t13,                                               
        IFNULL(t14,0) t14,                                               
        IFNULL(t15,0) t15,                                               
        IFNULL(t16,0) t16,                                               
        IFNULL(t17,0) t17,                                               
        IFNULL(t18,0) t18,                                               
        IFNULL(t19,0) t19,                                               
        IFNULL(t20,0) t20,                                               
        IFNULL(t21,0) t21,                                               
        IFNULL(t22,0) t22,                                               
        IFNULL(t23,0) t23,                                               
        IFNULL(t24,0) t24,                                               
        IFNULL(t25,0) t25,                                               
        IFNULL(t26,0) t26,                                               
        IFNULL(t27,0) t27,                                               
        IFNULL(t28,0) t28,                                               
        IFNULL(t29,0) t29,                                               
        IFNULL(t30,0) t30,                                               
        IFNULL(t31,0) t31,                                               
        x_total,                                                           
        urut                                                             
        FROM summ                                                        
        ORDER BY urut,nom_unit";

        $data = collect(DB::select($subquery));

        $site = Site::where('status_website', 1)->get();

        return view('mohh.index', compact('data', 'site'));
    }
}
