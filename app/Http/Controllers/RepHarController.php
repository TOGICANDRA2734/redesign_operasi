<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepHarController extends Controller
{
    public function index(Request $request)
    {
        $site = Site::where('status_website',1)->get();
        $subquery = "WITH summ AS
        (
        SELECT
        'TP' db,
        tp.nom_unit,
        LEFT(tp.nom_unit,4) k_kode,
        SUM(IF(tp.aktivitas='001',tp.jam,0)) ob,
        SUM(IF(tp.aktivitas='020',tp.jam,0)) gen,
        SUM(IF(tp.aktivitas='015',tp.jam,0)) trav,
        SUM(IF(tp.aktivitas='023',tp.jam,0)) rent,
        SUM(IF((tp.aktivitas='002') OR
               (tp.aktivitas='004'),tp.jam,0)) coal,
        SUM(IF(LEFT(tp.aktivitas,1)='0',tp.jam,0)) totalwh,
        SUM(IF(LEFT(tp.aktivitas,1)='B',tp.jam,0)) bd,
        SUM(tp.jam) mohh,
        SUM(IF(tp.aktivitas='s00',tp.jam,0)) s00,
        SUM(IF(tp.aktivitas='s01',tp.jam,0)) s01,
        SUM(IF(tp.aktivitas='s02',tp.jam,0)) s02,
        SUM(IF(tp.aktivitas='s03',tp.jam,0)) s03,
        SUM(IF(tp.aktivitas='s04',tp.jam,0)) s04,
        SUM(IF(tp.aktivitas='s05',tp.jam,0)) s05,
        SUM(IF(tp.aktivitas='s06',tp.jam,0)) s06,
        SUM(IF(tp.aktivitas='s07',tp.jam,0)) s07,
        SUM(IF(tp.aktivitas='s08',tp.jam,0)) s08,
        SUM(IF(tp.aktivitas='s09',tp.jam,0)) s09,
        SUM(IF(tp.aktivitas='s10',tp.jam,0)) s10,
        SUM(IF(tp.aktivitas='s11',tp.jam,0)) s11,
        SUM(IF(tp.aktivitas='s12',tp.jam,0)) s12,
        SUM(IF(tp.aktivitas='s13',tp.jam,0)) s13,
        SUM(IF(tp.aktivitas='s14',tp.jam,0)) s14,
        SUM(IF(tp.aktivitas='s15',tp.jam,0)) s15,
        SUM(IF(tp.aktivitas='s16',tp.jam,0)) s16,
        SUM(IF(tp.aktivitas='s17',tp.jam,0)) s17,
        SUM(IF(LEFT(tp.aktivitas,1)='S',tp.jam,0)) total_stb,
        ((SUM(tp.jam)-SUM(IF(LEFT(tp.aktivitas,1)='B',tp.jam,0)))/SUM(tp.jam)*100) ma,
        (SUM(IF(LEFT(tp.aktivitas,1)='0',tp.jam,0))/(SUM(tp.jam)-SUM(IF(LEFT(tp.aktivitas,1)='B',tp.jam,0))) * 100) ut,
        SUM(tp.ritasi) ritasi,
        SUM(tp.bcm) bcm,
        IFNULL(SUM(tp.distbcm)/SUM(tp.bcm),0) jarak,
        IFNULL((SUM(tp.bcm)/ SUM(IF(tp.aktivitas='001',tp.jam,0))),0) pty,
        IFNULL(fuel.ltr,0) liter,
        IFNULL((fuel.ltr/SUM(tp.bcm)),0) ltr_bcm,
        IFNULL((fuel.ltr/SUM(IF(LEFT(tp.aktivitas,1)='0',tp.jam,0))),0) ltr_wh
        FROM pma_tp tp
        LEFT JOIN
        (SELECT nom_unit,SUM(qty2)ltr FROM pma_fuel WHERE (tgl BETWEEN '2022-07-01' AND '2022-07-31') AND kodesite='E' AND del=0 GROUP BY nom_unit) fuel
        ON tp.nom_unit=fuel.nom_unit
        WHERE (tp.tgl BETWEEN '2022-07-01' AND '2022-07-31') AND tp.kodesite='E' AND tp.del=0
        GROUP BY tp.nom_unit,k_kode
        
        UNION ALL
        
        (
        SELECT
        'A2B' db, 
        a2b.nom_unit,
        LEFT(a2b.nom_unit,4) k_kode,
        SUM(IF(	(a2b.kode='008') OR
            (a2b.kode='009') OR
            (a2b.kode='010') OR
            (a2b.kode='011') OR
            (a2b.kode='012'),a2b.jam,0)) ob,
        SUM(IF(a2b.kode='020',a2b.jam,0)) gen,
        SUM(IF(a2b.kode='015',a2b.jam,0)) trav,
        SUM(IF(a2b.kode='023',a2b.jam,0)) rent,
        SUM(IF((a2b.kode='013') OR
            (a2b.kode='014'),a2b.jam,0)) coal,
        SUM(IF(LEFT(a2b.kode,1)='0',a2b.jam,0)) totalwh,
        SUM(IF(LEFT(a2b.kode,1)='B',a2b.jam,0)) bd,
        SUM(a2b.jam) mohh,
        SUM(IF(a2b.kode='s00',a2b.jam,0)) s00,
        SUM(IF(a2b.kode='s01',a2b.jam,0)) s01,
        SUM(IF(a2b.kode='s02',a2b.jam,0)) s02,
        SUM(IF(a2b.kode='s03',a2b.jam,0)) s03,
        SUM(IF(a2b.kode='s04',a2b.jam,0)) s04,
        SUM(IF(a2b.kode='s05',a2b.jam,0)) s05,
        SUM(IF(a2b.kode='s06',a2b.jam,0)) s06,
        SUM(IF(a2b.kode='s07',a2b.jam,0)) s07,
        SUM(IF(a2b.kode='s08',a2b.jam,0)) s08,
        SUM(IF(a2b.kode='s09',a2b.jam,0)) s09,
        SUM(IF(a2b.kode='s10',a2b.jam,0)) s10,
        SUM(IF(a2b.kode='s11',a2b.jam,0)) s11,
        SUM(IF(a2b.kode='s12',a2b.jam,0)) s12,
        SUM(IF(a2b.kode='s13',a2b.jam,0)) s13,
        SUM(IF(a2b.kode='s14',a2b.jam,0)) s14,
        SUM(IF(a2b.kode='s15',a2b.jam,0)) s15,
        SUM(IF(a2b.kode='s16',a2b.jam,0)) s16,
        SUM(IF(a2b.kode='s17',a2b.jam,0)) s17,
        SUM(IF(LEFT(a2b.kode,1)='S',a2b.jam,0)) total_stb,
        ((SUM(a2b.jam)-SUM(IF(LEFT(a2b.kode,1)='B',a2b.jam,0)))/SUM(a2b.jam)*100) ma,
        (SUM(IF(LEFT(a2b.kode,1)='0',a2b.jam,0))/(SUM(a2b.jam)-SUM(IF(LEFT(a2b.kode,1)='B',a2b.jam,0))) * 100) ut,
        IFNULL(tp.ritasi,0) ritasi,
        IFNULL(tp.bcm,0) bcm,
        IFNULL((tp.dist/tp.bcm),0) jarak,
        IFNULL(((tp.bcm)/ SUM(IF((a2b.kode='008') OR (a2b.kode='009') OR (a2b.kode='010') OR (a2b.kode='011') OR (a2b.kode='012'),a2b.jam,0))),0) pty,
        IFNULL(fuel.ltr,0) liter,
        IFNULL((fuel.ltr/SUM(tp.bcm)),0) ltr_bcm,
        IFNULL((fuel.ltr/SUM(IF(LEFT(a2b.kode,1)='0',a2b.jam,0))),0) ltr_wh
        FROM pma_a2b a2b
        LEFT JOIN
        (SELECT unit_load,SUM(ritasi) ritasi,SUM(bcm) bcm, SUM(distbcm) dist FROM pma_tp WHERE (tgl BETWEEN '2022-07-01' AND '2022-07-31') AND kodesite='E' AND del=0 GROUP BY unit_load) tp
        ON a2b.nom_unit=tp.unit_load
        LEFT JOIN
        (SELECT nom_unit,SUM(qty2)ltr FROM pma_fuel WHERE (tgl BETWEEN '2022-07-01' AND '2022-07-31') AND kodesite='E' AND del=0 GROUP BY nom_unit) fuel
        ON a2b.nom_unit=fuel.nom_unit
        WHERE (a2b.tgl BETWEEN '2022-07-01' AND '2022-07-31') AND a2b.kodesite='E' AND a2b.del=0
        GROUP BY a2b.nom_unit
        )
        )
        SELECT 
        a.*,IFNULL(b.gol,0) gol FROM summ a
        LEFT JOIN (SELECT kode_left,gol FROM unit_urut) b
        ON a.k_kode = b.kode_left
        ORDER BY b.gol,db,a.nom_unit";

        $data = collect(DB::select($subquery));


        return view('rephar.index', compact('site', 'data'));
    }
}
