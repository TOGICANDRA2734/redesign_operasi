<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
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


        $subquery = "SELECT A.tgl, D.icon_cuaca icon, SUM(A.ob)ob_act,SUM(A.coal)coal_act,SUM(B.ob)ob_plan,SUM(B.coal)coal_plan,
        ((SUM(A.ob)/SUM(B.ob))*100)ob_ach,((SUM(A.coal)/SUM(B.coal))*100)coal_ach, C.kodesite, C.namasite, C.gambar
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE tgl=CURDATE()-1 GROUP BY tgl, kodesite) B 
        ON A.tgl = B.tgl
        JOIN site C
        ON A.kodesite = C.kodesite
        JOIN pma_dailyprod_cuacaicon D
        ON A.cuaca = D.kode_cuaca
        WHERE A.TGL=CURDATE()-1
        GROUP BY A.tgl, A.kodesite
        ORDER BY C.id";

        $data = collect(DB::select($subquery));

        // Data Detail PTY
        $subquery = "SELECT                                                           
        b.namasite,
        nom_unit,
        AVG(pty) avg_pty,                                                        
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
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE tgl=CURDATE()-1 GROUP BY tgl, kodesite) B 
        ON A.tgl = B.tgl
        JOIN site C
        ON A.kodesite = C.kodesite
        JOIN pma_dailyprod_cuacaicon D
        ON A.cuaca = D.kode_cuaca
        WHERE A.TGL=CURDATE()-1
        GROUP BY A.tgl, A.kodesite
        ORDER BY C.id";

        $data = collect(DB::select($subquery));

        // Data Detail PTY
        $subquery = "SELECT                                                           
        b.namasite,
        nom_unit,
        AVG(pty) avg_pty,                                                        
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

        $subquery = "SELECT RIGHT(A.tgl, 2) tgl, SUM(A.OB) ob_act, SUM(B.OB) ob_plan
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl ORDER BY tgl) B
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
        $subquery = "SELECT RIGHT(A.tgl, 2) tgl, SUM(A.coal) coal_act, SUM(B.coal) coal_plan
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl) B
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
        $subquery = "SELECT A.tgl tgl, SUM(A.OB) ob_act, SUM(B.OB) ob_plan, SUM(A.coal) coal_act, SUM(B.coal) coal_plan, C.namasite, C.kodesite
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE ".$tanggal." AND kodesite = '".$site."' GROUP BY tgl) B
        ON A.tgl = B.tgl
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

        return view('dashboard.show', compact('data','data_prod_ob','data_plan_ob','data_prod_coal','data_plan_coal', 'pit', 'kendala', 'post', 'site'));
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
        $bulan = Carbon::now();

        $site=$request->site ? "AND A.kodesite = '".$request->site."'" : ''; 
        $pit=$request->pit ? "AND A.pit='".$request->pit."'" : '';
        $start=$request->start ? '' : '';
        $end=$request->end ? '' : '';

        if($start != null ){
            $tanggal =  "TGL BETWEEN '" . $start . "' AND '" . $end . "'";
            $tanggalKedua =  "A.TGL BETWEEN '" . $start . "' AND '" . $end . "'";    
        }
        else {
            $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";
            $tanggalKedua =  "A.TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";    
        }

    
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


        $subquery = "SELECT A.tgl, D.icon_cuaca icon, SUM(A.ob)ob_act,SUM(A.coal)coal_act,SUM(B.ob)ob_plan,SUM(B.coal)coal_plan,
        ((SUM(A.ob)/SUM(B.ob))*100)ob_ach,((SUM(A.coal)/SUM(B.coal))*100)coal_ach, C.kodesite, C.namasite, C.gambar
        FROM pma_dailyprod_tc A
        JOIN (SELECT * FROM pma_dailyprod_plan WHERE tgl=CURDATE()-1 GROUP BY tgl, kodesite) B 
        ON A.tgl = B.tgl
        JOIN site C
        ON A.kodesite = C.kodesite
        JOIN pma_dailyprod_cuacaicon D
        ON A.cuaca = D.kode_cuaca
        WHERE A.TGL=CURDATE()-1
        GROUP BY A.tgl, A.kodesite
        ORDER BY C.id";

        $data = collect(DB::select($subquery));

        // Data Detail PTY
        $subquery = "SELECT                                                           
        b.namasite,
        nom_unit,
        AVG(pty) avg_pty,                                                        
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
        


        // Fetch all records
        $response['data_detail_OB_prod'] = $data_detail_OB_prod;
        $response['data_detail_OB_plan'] = $data_detail_OB_plan;
        $response['data_prod_ob'] = $data_prod_ob;
        $response['data_plan_ob'] = $data_plan_ob;
        $response['data_detail_coal_prod'] = $data_detail_coal_prod;
        $response['data_detail_coal_plan'] = $data_detail_coal_plan;
        $response['data_prod_coal'] = $data_prod_coal;
        $response['data_plan_coal'] = $data_plan_coal;
        $response['data'] = $data;
        return response()->json($response);

        return view('dashboard.index', compact('data_detail_OB_prod', 'data_detail_OB_plan', 'data_prod_ob', 'data_plan_ob', 'data_detail_coal_prod', 'data_detail_coal_plan', 'data_prod_coal', 'data_plan_coal', 'data', 'dataPty'));
    }
}
