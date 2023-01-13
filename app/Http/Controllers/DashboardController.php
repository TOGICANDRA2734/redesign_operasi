<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /**
         * Overburden Data
         */

        $bulan = Carbon::now();

        $record_OB_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('RIGHT(tgl,2) as prod_tgl, SUM(OB) as OB'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()])
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $record_OB_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('RIGHT(tgl,2) as prod_tgl, SUM(OB) as OB'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()])
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $data_prod_ob = [];
        $data_plan_ob = [];

        foreach ($record_OB_prod as $row) {
            $data_prod_ob['label'][] = (int) $row->prod_tgl;
            $data_prod_ob['data'][] = $row->OB;
        }

        foreach ($record_OB_plan as $row) {
            $data_plan_ob['label'][] = (int) $row->prod_tgl;
            $data_plan_ob['data'][] = $row->OB;
        }

        $data_prod_ob['chart_data_prod_ob'] = json_encode($data_prod_ob);
        $data_plan_ob['chart_data_plan_ob'] = json_encode($data_plan_ob);


        $data_detail_OB_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('SUM(OB) as OB'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()->subDay(1)])
            ->get();

        $data_detail_OB_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('SUM(OB) as OB'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()->subDay(1)])
            ->get();


        /**
         * Coal Data
         */
        $record_coal_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('RIGHT(tgl,2) as prod_tgl, SUM(coal) as coal'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()])
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $record_coal_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('RIGHT(tgl,2) as prod_tgl, SUM(coal) as coal'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()])
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $data_prod_coal = [];
        $data_plan_coal = [];

        foreach ($record_coal_prod as $row) {
            $data_prod_coal['label'][] = (int) $row->prod_tgl;
            $data_prod_coal['data'][] = $row->coal;
        }

        foreach ($record_coal_plan as $row) {
            $data_plan_coal['label'][] = (int) $row->prod_tgl;
            $data_plan_coal['data'][] = $row->coal;
        }

        $data_prod_coal['chart_data_prod_coal'] = json_encode($data_prod_coal);
        $data_plan_coal['chart_data_plan_coal'] = json_encode($data_plan_coal);

        $data_detail_coal_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('SUM(coal) as coal'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()->subDay(1)])
            ->get();

        $data_detail_coal_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('SUM(coal) as coal'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()->subDay(1)])
            ->get();


        $subquery = "SELECT A.tgl, D.icon_cuaca icon,  sum(A.ob) ob_act, sum(A.coal) coal_act, B.ob ob_plan, B.coal coal_plan, ((sum(A.ob)/B.ob)*100)ob_ach ,((sum(A.coal)/B.coal)*100)coal_ach , C.kodesite, C.namasite, C.gambar
        FROM pma_dailyprod_tc A
        JOIN (SELECT sum(ob) ob, sum(coal) coal, kodesite, tgl 
        FROM pma_dailyprod_plan 
        WHERE tgl=DATE_SUB(CURDATE(), INTERVAL 1 DAY) 
        and del=0 
        GROUP BY kodesite, tgl) B
        ON (a.kodesite = b.kodesite and A.tgl=b.tgl)
        JOIN (SELECT * FROM site GROUP BY kodesite) c
        ON a.kodesite = c.kodesite
        JOIN pma_dailyprod_cuacaicon D
        ON A.cuaca = D.kode_cuaca
        WHERE A.TGL=DATE_SUB(CURDATE(), INTERVAL 1 DAY) 
        and A.del=0
        GROUP BY A.kodesite, A.tgl
        ORDER BY C.id";

        $data = collect(DB::select($subquery));

        // Data Detail PTY
        $subquery = "SELECT                                                           
        b.namasite,
        nom_unit,
        ROUND(AVG(pty), 1) avg_pty,                                                                                    
        IFNULL(SUM(CASE WHEN jam = 6 THEN pty END),'-') j1,                    
        IFNULL(SUM(CASE WHEN jam = 7 THEN pty END),'-') j2,                    
        IFNULL(SUM(CASE WHEN jam = 8 THEN pty END),'-') j3,                          
        IFNULL(SUM(CASE WHEN jam = 9 THEN pty END),'-') j4,                    
        IFNULL(SUM(CASE WHEN jam = 10 THEN pty END),'-') j5,                          
        IFNULL(SUM(CASE WHEN jam = 11 THEN pty END),'-') j6,                    
        IFNULL(SUM(CASE WHEN jam = 12 THEN pty END),'-') j7,                          
        IFNULL(SUM(CASE WHEN jam = 13 THEN pty END),'-') j8,                    
        IFNULL(SUM(CASE WHEN jam = 14 THEN pty END),'-') j9,                          
        IFNULL(SUM(CASE WHEN jam = 15 THEN pty END),'-') j10,                    
        IFNULL(SUM(CASE WHEN jam = 16 THEN pty END),'-') j11,                          
        IFNULL(SUM(CASE WHEN jam = 17 THEN pty END),'-') j12,                    
        IFNULL(SUM(CASE WHEN jam = 18 THEN pty END),'-') j13,                          
        IFNULL(SUM(CASE WHEN jam = 19 THEN pty END),'-') j14,                            
        IFNULL((SELECT dist FROM pma_dailyprod_pty X WHERE dist IS NOT NULL AND nom_unit=A.nom_unit AND tgl=CURDATE() AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty WHERE nom_unit=x.nom_unit  AND tgl=curdate()) ORDER BY nom_unit DESC LIMIT 1), '-') dist,
        IFNULL((SELECT ket FROM pma_dailyprod_pty X WHERE ket IS NOT NULL AND nom_unit=A.nom_unit AND tgl=CURDATE() AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty WHERE nom_unit=x.nom_unit AND tgl=curdate()) ORDER BY nom_unit DESC LIMIT 1), '-') ket
        FROM pma_dailyprod_pty A 
        JOIN site B
        ON A.kodesite = B.kodesite                                         
        WHERE tgl=CURDATE() AND del=0
        GROUP BY a.kodesite, nom_unit,TYPE
        ORDER BY b.id, nom_unit";

        $dataPty = collect(DB::select($subquery));

        // Total Data Pty
        $subquery = "SELECT SUM(pty) total_pty
        FROM pma_dailyprod_pty A 
        JOIN site B
        ON A.kodesite = B.kodesite       
        JOIN plant_tipe_unit C
        ON LEFT(A.nom_unit,4)= C.kode                                      
        WHERE tgl=CURDATE() AND del=0 AND C.gol_1='2' and a.kodesite='".Auth::user()->kodesite."'
        ORDER BY b.id, nom_unit";
        $totalDataPty = collect(DB::select($subquery));

        // Total Data Per Site
        $subquery = "SELECT B.namasite, SUM(pty) pty
        FROM pma_dailyprod_pty A 
        JOIN site B
        ON A.kodesite = B.kodesite       
        JOIN plant_tipe_unit C
        ON LEFT(A.nom_unit,4)= C.kode                                      
        WHERE tgl=CURDATE() AND del=0 AND C.gol_1='2'
        GROUP BY A.kodesite
        ORDER BY b.id, nom_unit";
        $totalDataPtySite = collect(DB::select($subquery));

        // Data Detail Coal
        $subquery = "SELECT A.id,
        b.namasite,
        pit,
        ROUND(AVG(rit), 1) avg_rit,                                                                                          
        IFNULL(SUM(CASE WHEN jam = 6 THEN rit END),'-') j1,                    
        IFNULL(SUM(CASE WHEN jam = 7 THEN rit END),'-') j2,                    
        IFNULL(SUM(CASE WHEN jam = 8 THEN rit END),'-') j3,                          
        IFNULL(SUM(CASE WHEN jam = 9 THEN rit END),'-') j4,                    
        IFNULL(SUM(CASE WHEN jam = 10 THEN rit END),'-') j5,                          
        IFNULL(SUM(CASE WHEN jam = 11 THEN rit END),'-') j6,                    
        IFNULL(SUM(CASE WHEN jam = 12 THEN rit END),'-') j7,                          
        IFNULL(SUM(CASE WHEN jam = 13 THEN rit END),'-') j8,                    
        IFNULL(SUM(CASE WHEN jam = 14 THEN rit END),'-') j9,                          
        IFNULL(SUM(CASE WHEN jam = 15 THEN rit END),'-') j10,                    
        IFNULL(SUM(CASE WHEN jam = 16 THEN rit END),'-') j11,                          
        IFNULL(SUM(CASE WHEN jam = 17 THEN rit END),'-') j12,                    
        IFNULL(SUM(CASE WHEN jam = 18 THEN rit END),'-') j13,                          
        IFNULL(SUM(CASE WHEN jam = 19 THEN rit END),'-') j14,   
        IFNULL((SELECT ket FROM pma_dailyprod_pty_coal X WHERE ket IS NOT NULL AND tgl=CURDATE() AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty_coal WHERE tgl=CURDATE()) LIMIT 1), '-') ket
        FROM pma_dailyprod_pty_coal A 
        JOIN site B
        ON A.kodesite = B.kodesite                                             
        WHERE tgl=CURDATE() AND del=0
        GROUP BY a.kodesite
        ORDER BY b.id";
        $dataCoal = collect(DB::select($subquery));

        $subquery = "SELECT SUM(rit) total_rit
        FROM pma_dailyprod_pty_coal A 
        JOIN site B
        ON A.kodesite = B.kodesite                                             
        WHERE tgl=CURDATE() AND del=0 and a.kodesite='".Auth::user()->kodesite."'
        ORDER BY b.id";
        $totalDataCoal = collect(DB::select($subquery));

        // Total Data Per Site
        $subquery = "SELECT B.namasite namasite, SUM(rit) rit
        FROM pma_dailyprod_pty_coal A 
        JOIN site B
        ON A.kodesite = B.kodesite                                             
        WHERE tgl=CURDATE() AND del=0
        GROUP BY A.kodesite
        ORDER BY b.id";
        $totalDataRitSite = collect(DB::select($subquery));

        return view('dashboard.index', compact('data_detail_OB_prod', 'data_detail_OB_plan', 'data_prod_ob', 'data_plan_ob', 'data_detail_coal_prod', 'data_detail_coal_plan', 'data_prod_coal', 'data_plan_coal', 'data', 'dataPty', 'totalDataPty', 'dataCoal', 'totalDataCoal', 'totalDataPtySite', 'totalDataRitSite'));
    }

    public function index_filtered($namasite)
    {
        /**
         * Overburden Data
         */
        $bulan = Carbon::now();

        $record_OB_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('RIGHT(tgl,2) as prod_tgl, SUM(OB) as OB'))
            ->join('site', 'pma_dailyprod_tc.kodesite', '=', 'site.kodesite')
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()])
            ->where('namasite', '=', $namasite)
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $record_OB_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('RIGHT(tgl,2) as prod_tgl, SUM(OB) as OB'))
            ->join('site', 'pma_dailyprod_plan.kodesite', '=', 'site.kodesite')
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()])
            ->where('namasite', '=', $namasite)
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $data_prod_ob = [];
        $data_plan_ob = [];

        foreach ($record_OB_prod as $row) {
            $data_prod_ob['label'][] = (int) $row->prod_tgl;
            $data_prod_ob['data'][] = $row->OB;
        }

        foreach ($record_OB_plan as $row) {
            $data_plan_ob['label'][] = (int) $row->prod_tgl;
            $data_plan_ob['data'][] = $row->OB;
        }

        $data_prod_ob['chart_data_prod_ob'] = json_encode($data_prod_ob);
        $data_plan_ob['chart_data_plan_ob'] = json_encode($data_plan_ob);


        $data_detail_OB_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('SUM(OB) as OB'))
            ->join('site', 'pma_dailyprod_tc.kodesite', '=', 'site.kodesite')
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()])
            ->where('namasite', '=', $namasite)
            ->get();

        $data_detail_OB_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('SUM(OB) as OB'))
            ->join('site', 'pma_dailyprod_plan.kodesite', '=', 'site.kodesite')
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()])
            ->where('namasite', '=', $namasite)
            ->get();


        /**
         * Coal Data
         */
        $record_coal_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('RIGHT(tgl,2) as prod_tgl, SUM(coal) as coal'))
            ->join('site', 'pma_dailyprod_tc.kodesite', '=', 'site.kodesite')
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()])
            ->where('namasite', '=', $namasite)
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $record_coal_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('RIGHT(tgl,2) as prod_tgl, SUM(coal) as coal'))
            ->join('site', 'pma_dailyprod_plan.kodesite', '=', 'site.kodesite')
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()])
            ->where('namasite', '=', $namasite)
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $data_prod_coal = [];
        $data_plan_coal = [];

        foreach ($record_coal_prod as $row) {
            $data_prod_coal['label'][] = (int) $row->prod_tgl;
            $data_prod_coal['data'][] = $row->coal;
        }

        foreach ($record_coal_plan as $row) {
            $data_plan_coal['label'][] = (int) $row->prod_tgl;
            $data_plan_coal['data'][] = $row->coal;
        }

        $data_prod_coal['chart_data_prod_coal'] = json_encode($data_prod_coal);
        $data_plan_coal['chart_data_plan_coal'] = json_encode($data_plan_coal);

        $data_detail_coal_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('SUM(coal) as coal'))
            ->join('site', 'pma_dailyprod_tc.kodesite', '=', 'site.kodesite')
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()])
            ->where('namasite', '=', $namasite)
            ->get();

        $data_detail_coal_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('SUM(coal) as coal'))
            ->join('site', 'pma_dailyprod_plan.kodesite', '=', 'site.kodesite')
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()])
            ->where('namasite', '=', $namasite)
            ->get();


        $subquery = "SELECT A.tgl, D.icon_cuaca icon, SUM(A.ob)ob_act,SUM(A.coal)coal_act,SUM(B.ob)ob_plan,SUM(B.coal)coal_plan,
        ((SUM(A.ob)/SUM(B.ob))*100)ob_ach,((SUM(A.coal)/SUM(B.coal))*100)coal_ach, C.kodesite, C.namasite, C.gambar
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE tgl=DATE_SUB(CURDATE(), INTERVAL 1 DAY) GROUP BY tgl, kodesite) B 
        ON A.tgl = B.tgl
        JOIN site C
        ON A.kodesite = C.kodesite
        JOIN pma_dailyprod_cuacaicon D
        ON A.cuaca = D.kode_cuaca
        WHERE A.TGL=DATE_SUB(CURDATE(), INTERVAL 1 DAY)
        GROUP BY A.tgl, A.kodesite
        ORDER BY C.id";

        $data = collect(DB::select($subquery)) ;

        // Data Detail PTY
        $subquery = "SELECT                                                           
        b.namasite,
        nom_unit,
        ROUND(AVG(pty), 1) avg_pty,                                                        
        IFNULL(SUM(CASE WHEN jam = 7 THEN pty END),'-') j1,                    
        IFNULL(SUM(CASE WHEN jam = 8 THEN pty END),'-') j2,                          
        IFNULL(SUM(CASE WHEN jam = 9 THEN pty END),'-') j3,                    
        IFNULL(SUM(CASE WHEN jam = 10 THEN pty END),'-') j4,                          
        IFNULL(SUM(CASE WHEN jam = 11 THEN pty END),'-') j5,                    
        IFNULL(SUM(CASE WHEN jam = 12 THEN pty END),'-') j6,                          
        IFNULL(SUM(CASE WHEN jam = 13 THEN pty END),'-') j7,                    
        IFNULL(SUM(CASE WHEN jam = 14 THEN pty END),'-') j8,                          
        IFNULL(SUM(CASE WHEN jam = 15 THEN pty END),'-') j9,                    
        IFNULL(SUM(CASE WHEN jam = 16 THEN pty END),'-') j10,                          
        IFNULL(SUM(CASE WHEN jam = 17 THEN pty END),'-') j11,                    
        IFNULL(SUM(CASE WHEN jam = 18 THEN pty END),'-') j12,                          
        IFNULL(SUM(CASE WHEN jam = 19 THEN pty END),'-') j13,                          
        (SELECT dist FROM pma_dailyprod_pty X WHERE dist IS NOT NULL AND nom_unit=A.nom_unit AND tgl=CURDATE() AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty WHERE nom_unit=x.nom_unit) ORDER BY nom_unit DESC LIMIT 1) dist,
        (SELECT ket FROM pma_dailyprod_pty X WHERE dist IS NOT NULL AND nom_unit=A.nom_unit AND tgl=CURDATE() AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty WHERE nom_unit=x.nom_unit) ORDER BY nom_unit DESC LIMIT 1) ket
        FROM pma_dailyprod_pty A 
        JOIN site B
        ON A.kodesite = B.kodesite                                         
        WHERE tgl=CURDATE() AND del=0
        GROUP BY a.kodesite, nom_unit,TYPE
        ORDER BY b.id, nom_unit";

        $dataPty = collect(DB::select($subquery));
        
        return view('dashboard.index', compact('data_detail_OB_prod', 'data_detail_OB_plan', 'data_prod_ob', 'data_plan_ob', 'data_detail_coal_prod', 'data_detail_coal_plan', 'data_prod_coal', 'data_plan_coal', 'data', 'dataPty'));
    }

    public function show($site)
    {
        $bulan = Carbon::now();
        $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";
        $tanggalKedua =  "A.TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";

        /**
         * Overburden
         */
        $bulan = Carbon::now();

        $data_detail_OB_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('SUM(OB) as OB'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()->subDay(1)])
            ->where('kodesite', '=', $site)
            ->get();

        $data_detail_OB_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('SUM(OB) as OB'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()->subDay(1)])
            ->where('kodesite', '=', $site)
            ->get();

        $data_detail_coal_prod = DB::table('pma_dailyprod_tc')
            ->select(DB::raw('SUM(coal) as coal'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()->subDay(1)])
            ->where('kodesite', '=', $site)
            ->get();

        $data_detail_coal_plan = DB::table('pma_dailyprod_plan')
            ->select(DB::raw('SUM(coal) as coal'))
            ->whereBetween('tgl', [$bulan->startOfMonth()->copy(), Carbon::now()->subDay(1)])
            ->where('kodesite', '=', $site)
            ->get();


        $subquery = "SELECT RIGHT(A.tgl, 2) tgl, SUM(A.OB) ob_act, SUM(B.OB) ob_plan
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl ORDER BY tgl) B
        ON A.tgl = B.tgl
        WHERE ".$tanggalKedua."
        AND A.kodesite = '".$site."'
        GROUP BY A.tgl
        ORDER BY A.tgl";

        $data = collect(DB::select($subquery));

        $subquery = "SELECT RIGHT(A.tgl, 2) tgl, sum(A.OB) ob_act, B.OB ob_plan
        FROM pma_dailyprod_tc A
        JOIN (SELECT tgl, sum(ob) ob FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl ORDER BY tgl) B
        ON A.tgl = B.tgl
        WHERE ".$tanggalKedua."
        AND A.kodesite = '".$site."'
        GROUP BY A.tgl
        ORDER BY A.tgl";

        $record_ob = collect(DB::select($subquery));

        $data_prod_ob = [];
        $data_plan_ob = [];

        foreach ($record_ob as $row) {
            $data_prod_ob['label'][] = (int) $row->tgl;
            $data_prod_ob['data'][] = $row->ob_act;
            $data_plan_ob['label'][] = (int) $row->tgl;
            $data_plan_ob['data'][] = $row->ob_plan;
        }

        $data_prod_ob['chart_data_prod_ob'] = json_encode($data_prod_ob);
        $data_plan_ob['chart_data_plan_ob'] = json_encode($data_plan_ob);

        /**
         * Coal Data
         */
        $subquery = "SELECT RIGHT(A.tgl, 2) tgl, sum(A.coal) coal_act, B.coal coal_plan
        FROM pma_dailyprod_tc A
        JOIN (SELECT tgl, sum(coal) coal FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl) B
        ON A.tgl = B.tgl
        WHERE ".$tanggalKedua."
        AND A.kodesite = '".$site."'
        GROUP BY A.tgl
        ORDER BY A.tgl";

        $record_coal = collect(DB::select($subquery));

        $data_prod_coal = [];
        $data_plan_coal = [];

        foreach ($record_coal as $row) {
            $data_prod_coal['label'][] = (int) $row->tgl;
            $data_prod_coal['data'][] = $row->coal_act;
            $data_plan_coal['label'][] = (int) $row->tgl;
            $data_plan_coal['data'][] = $row->coal_plan;
        }

        $data_prod_coal['chart_data_prod_coal'] = json_encode($data_prod_coal);
        $data_plan_coal['chart_data_plan_coal'] = json_encode($data_plan_coal);

        /**
         * Data Bulanan
         */
        $subquery = "SELECT A.tgl tgl, SUM(A.OB) ob_act, (select sum(OB) FROM pma_dailyprod_plan WHERE tgl=A.tgl AND kodesite = '".$site."' GROUP BY tgl) ob_plan, SUM(A.coal) coal_act, (select sum(coal) FROM pma_dailyprod_plan WHERE tgl=A.tgl AND kodesite = '".$site."' GROUP BY tgl) coal_plan, C.namasite, C.kodesite
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl) B
        ON a.tgl = B.tgl
        JOIN site C
        ON A.kodesite = C.kodesite
        WHERE ".$tanggalKedua."
        AND A.kodesite = '".$site."'
        GROUP BY A.tgl";
        $data = collect(DB::select($subquery));


        /**
         * Pit
         */
        $subquery = "SELECT DISTINCT ket
        FROM pma_dailyprod_pit
        WHERE kodesite='".$site."'
        ORDER BY ket";
        $pit = collect(DB::select($subquery));

        /**
         * Kendala
         */
        $subquery = "SELECT *
        FROM pma_dailyprod_kendala
        WHERE ".$tanggal." AND
        kodesite='".$site."'
        ORDER BY tgl";
        $kendala = collect(DB::select($subquery));

        $post = DB::table('pma_dailyprod_posts')->select('id')->where('kodesite', $site)->pluck('id');
        $post = Post::find($post)->first();


        return view('dashboard.show', compact('data','data_prod_ob','data_plan_ob', 'data_detail_OB_prod', 'data_detail_OB_plan','data_prod_coal','data_plan_coal', 'data_detail_coal_prod', 'data_detail_coal_plan', 'pit', 'kendala', 'post', 'site'));
    }

    public function show_data($site='', $pit='')
    {
        $bulan = Carbon::now();
        $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";
        $tanggalKedua =  "A.TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";    
        
        /**
         * Overburden
         */
        $subquery = "SELECT RIGHT(A.tgl, 2) tgl, SUM(A.OB) ob_act, SUM(B.OB) ob_plan
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl ORDER BY tgl) B
        ON A.tgl = B.tgl
        WHERE ".$tanggalKedua."
        AND A.kodesite = '".$site."'
        AND A.pit= '".$pit."'
        GROUP BY A.tgl
        ORDER BY A.tgl";

        $record_ob = collect(DB::select($subquery));

        $data_prod_ob = [];
        $data_plan_ob = [];

        foreach ($record_ob as $row) {
            $data_prod_ob['label'][] = (int) $row->tgl;
            $data_prod_ob['data'][] = $row->ob_act;
            $data_plan_ob['label'][] = (int) $row->tgl;
            $data_plan_ob['data'][] = $row->ob_plan;
        }

        $data_prod_ob['chart_data_prod_ob'] = json_encode($data_prod_ob);
        $data_plan_ob['chart_data_plan_ob'] = json_encode($data_plan_ob);

        /**
         * Coal Data
         */
        $subquery = "SELECT RIGHT(A.tgl, 2) tgl, SUM(A.coal) coal_act, SUM(B.coal) coal_plan
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl) B
        ON A.tgl = B.tgl
        WHERE ".$tanggalKedua."
        AND A.kodesite = '".$site."'
        AND A.pit= '".$pit."'
        GROUP BY A.tgl
        ORDER BY A.tgl";

        $record_coal = collect(DB::select($subquery));

        $data_prod_coal = [];
        $data_plan_coal = [];

        foreach ($record_coal as $row) {
            $data_prod_coal['label'][] = (int) $row->tgl;
            $data_prod_coal['data'][] = $row->coal_act;
            $data_plan_coal['label'][] = (int) $row->tgl;
            $data_plan_coal['data'][] = $row->coal_plan;
        }

        $data_prod_coal['chart_data_prod_coal'] = json_encode($data_prod_coal);
        $data_plan_coal['chart_data_plan_coal'] = json_encode($data_plan_coal);

        /**
         * Data Bulanan
         */
        $subquery = "SELECT A.tgl tgl, SUM(A.OB) ob_act, SUM(B.OB) ob_plan, SUM(A.coal) coal_act, SUM(B.coal) coal_plan, C.namasite, C.kodesite
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl) B
        ON A.tgl = B.tgl
        JOIN site C
        ON A.kodesite = C.kodesite
        WHERE ".$tanggalKedua."
        AND A.kodesite = '".$site."'
        AND A.pit= '".$pit."'
        GROUP BY A.tgl";
        $data = collect(DB::select($subquery));

        /**
         * Pit
         */
        $subquery = "SELECT DISTINCT ket
        FROM pma_dailyprod_pit
        WHERE kodesite='".$site."'
        ORDER BY ket";
        $pit = collect(DB::select($subquery));


        /**
         * Kendala
         */
        $subquery = "SELECT *
        FROM pma_dailyprod_kendala
        WHERE ".$tanggal." AND
        kodesite='".$site."'";
        $kendala = collect(DB::select($subquery));

        $post = DB::table('pma_dailyprod_posts')->select('id')->where('kodesite', $site)->pluck('id');
        $post = Post::find($post)->first();

        return view('dashboard.show', compact('data','data_prod_ob','data_plan_ob','data_prod_coal','data_plan_coal', 'pit', 'kendala', 'post', 'site'));        
    }
    
    public function show_data_filtered(Request $request)
    {   
        $where1 = '';

        if (count($request->all()) > 1) {              
            // Where 1
            $where1 .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where1 .= ($request->has('site') && !empty($request->site)) ? " AND " : "";
            $where1 .= ($request->has('site') && !empty($request->site)) ? "kodesite='" . $request->site . "'" : "";
            $where1 .= " AND DEL=0";
        } else {
            $where1 .= "TGL BETWEEN '" . Carbon::now()->startOfYear() . "' AND '" . Carbon::now()->endOfYear() . "' AND DEL=0";
        }

        // Data Produksi TC OB
        $subquery = "SELECT RIGHT(tgl,2) as prod_tgl,
        SUM(OB) as OB 
        from PMA_DAILYPROD_TC 
        where ".$where1." 
        group by tgl 
        order by tgl asc";
        $record_OB_prod = collect(DB::select($subquery));

        $subquery = "SELECT RIGHT(tgl,2) as prod_tgl,
        SUM(OB) as OB 
        from PMA_DAILYPROD_PLAN 
        where ".$where1." 
        group by tgl 
        order by tgl asc";
        $record_OB_plan = collect(DB::select($subquery));

        $data_detail_OB_prod = $record_OB_prod->sum('OB');
        $data_detail_OB_plan = $record_OB_plan->sum('OB');

        $data_prod_ob = [];
        $data_plan_ob = [];

        foreach ($record_OB_prod as $row) {
            $data_prod_ob['label'][] = (int) $row->prod_tgl;
            $data_prod_ob['data'][] = $row->OB;
        }

        foreach ($record_OB_plan as $row) {
            $data_plan_ob['label'][] = (int) $row->prod_tgl;
            $data_plan_ob['data'][] = $row->OB;
        }

        /**
         * Coal Data
         */
        $subquery = "SELECT RIGHT(tgl,2) as prod_tgl, SUM(coal) as coal 
        FROM pma_dailyprod_tc
        WHERE ".$where1."
        GROUP BY `tgl` 
        ORDER BY `tgl` asc";
        $record_coal_prod = collect(DB::select($subquery));


        $subquery = "SELECT RIGHT(tgl,2) as prod_tgl, SUM(coal) as coal 
        FROM pma_dailyprod_plan
        WHERE ".$where1."
        GROUP BY `tgl` 
        ORDER BY `tgl` asc";
        $record_coal_plan = collect(DB::select($subquery));

        $data_detail_coal_prod = $record_coal_prod->sum('coal');
        $data_detail_coal_plan = $record_coal_plan->sum('coal');

        $data_prod_coal = [];
        $data_plan_coal = [];

        foreach ($record_coal_prod as $row) {
            $data_prod_coal['label'][] = (int) $row->prod_tgl;
            $data_prod_coal['data'][] = $row->coal;
        }

        foreach ($record_coal_plan as $row) {
            $data_plan_coal['label'][] = (int) $row->prod_tgl;
            $data_plan_coal['data'][] = $row->coal;
        }

        // Fetch all records
        $response['data_detail_OB_prod'] = $data_detail_OB_prod;
        $response['data_detail_OB_plan'] = $data_detail_OB_plan;
        $response['data_prod_ob'] = $data_prod_ob;
        $response['data_plan_ob'] = $data_plan_ob;
        $response['data_detail_coal_prod'] = $data_detail_coal_prod;
        $response['data_detail_coal_plan'] = $data_detail_coal_plan;
        $response['data_prod_coal'] = $data_prod_coal;
        $response['data_plan_coal'] = $data_plan_coal;
        $response['start'] = $request->start;
        $response['end'] = $request->end;
        return response()->json($response);
    }
}
