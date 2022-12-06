<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MohhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = '';
        
        if (count($request->all()) > 1) {              
            // Where 
            $where .= ($request->has('cari_1') && !empty($request->cari_1)) ? "nom_unit LIKE '%".$request->cari_1."%' " : "";
            $where .= ($request->has('cari_1') && $request->has('cari_2')) ? " AND " : "";
            $where .= ($request->has('cari_2') && !empty($request->cari_2)) ? "nom_unit LIKE '%".$request->cari_2."%' " : "";
            $where .= ($request->has('cari_2') && !empty($request->cari_2) && $request->has('bulan')) ? " AND " : "";
            $where .= ($request->has('cari_2') && $request->has('start')) ? " AND " : "";
            $where .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "kodesite='" . $request->pilihSite . "'" : "";
            $where .= ($request->has('start') && $request->has('end')) ? " AND " : "";
            $where .= "DEL=0";
        } else {
            $where .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND DEL=0";
            // $where .= " tgl BETWEEN '2022-11-01' AND '2022-11-31' AND del=0 AND kodesite='i'";
        }


        $subquery = "WITH summ AS                                                     
        (                                                               
        SELECT                                                           
        nom_unit,                                                        
        COUNT(nom_unit) jum,                                             
        ROUND(SUM(CASE WHEN DAY(tgl) = 1 THEN jam END),0) t1,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 2 THEN jam END),0) t2,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 3 THEN jam END),0) t3,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 4 THEN jam END),0) t4,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 5 THEN jam END),0) t5,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 6 THEN jam END),0) t6,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 7 THEN jam END),0) t7,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 8 THEN jam END),0) t8,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 9 THEN jam END),0) t9,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 10 THEN jam END),0) t10,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 11 THEN jam END),0) t11,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 12 THEN jam END),0) t12,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 13 THEN jam END),0) t13,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 14 THEN jam END),0) t14,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 15 THEN jam END),0) t15,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 16 THEN jam END),0) t16,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 17 THEN jam END),0) t17,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 18 THEN jam END),0) t18,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 19 THEN jam END),0) t19,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 20 THEN jam END),0) t20,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 21 THEN jam END),0) t21,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 22 THEN jam END),0) t22,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 23 THEN jam END),0) t23,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 24 THEN jam END),0) t24,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 25 THEN jam END),0) t25,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 26 THEN jam END),0) t26,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 27 THEN jam END),0) t27,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 28 THEN jam END),0) t28,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 29 THEN jam END),0) t29,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 30 THEN jam END),0) t30,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 31 THEN jam END),0) t31,                   
        ROUND(SUM(jam),0) x_total                                                   
        FROM pma_tp                                                       
        WHERE ".$where."
        GROUP BY nom_unit                                                
                                                                         
        UNION ALL                                                        
                                                                         
        SELECT                                                           
        nom_unit,                                                        
        COUNT(nom_unit) jum,                                            
        ROUND(SUM(CASE WHEN DAY(tgl) = 1 THEN jam END),0) t1,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 2 THEN jam END),0) t2,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 3 THEN jam END),0) t3,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 4 THEN jam END),0) t4,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 5 THEN jam END),0) t5,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 6 THEN jam END),0) t6,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 7 THEN jam END),0) t7,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 8 THEN jam END),0) t8,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 9 THEN jam END),0) t9,                     
        ROUND(SUM(CASE WHEN DAY(tgl) = 10 THEN jam END),0) t10,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 11 THEN jam END),0) t11,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 12 THEN jam END),0) t12,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 13 THEN jam END),0) t13,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 14 THEN jam END),0) t14,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 15 THEN jam END),0) t15,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 16 THEN jam END),0) t16,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 17 THEN jam END),0) t17,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 18 THEN jam END),0) t18,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 19 THEN jam END),0) t19,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 20 THEN jam END),0) t20,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 21 THEN jam END),0) t21,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 22 THEN jam END),0) t22,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 23 THEN jam END),0) t23,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 24 THEN jam END),0) t24,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 25 THEN jam END),0) t25,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 26 THEN jam END),0) t26,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 27 THEN jam END),0) t27,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 28 THEN jam END),0) t28,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 29 THEN jam END),0) t29,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 30 THEN jam END),0) t30,                   
        ROUND(SUM(CASE WHEN DAY(tgl) = 31 THEN jam END),0) t31,                   
        ROUND(SUM(jam),0) x_total                                                       
        FROM pma_a2b                                                      
        WHERE ".$where."
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
        x_total                                                      
        FROM summ   
                                                     
        ORDER BY nom_unit";
        $data = collect(DB::select($subquery));

        $site = Site::where('status_website', 1)->get();

        if (count($request->all()) > 1) {              
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('mohh.index', compact('site', 'data'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
