<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanProduksiAllExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;        
    }

    public function collection()
    {
        $where1 = "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
        $where2 = " TGL=a.tgl and kodesite=a.kodesite";

        // dd($where1, $where2);

        $subquery = "SELECT day(tgl) tgl_data,
        IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN ob END),1),'-') AS ob_1,
        IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN ob END),1),'-') AS ob_2,
        IFNULL(ROUND(SUM(OB),1),'-') AS sum_ob,
        (SELECT ROUND(SUM(OB),1) FROM PMA_DAILYPROD_PLAN WHERE ".$where2." GROUP BY TGL) plan_ob,
        IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN coal END),1),'-') AS coal_1,
        IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN coal END),1),'-') AS coal_2,
        IFNULL(ROUND(SUM(coal),1),'-') AS sum_coal,
        (SELECT ROUND(SUM(coal),1) FROM PMA_DAILYPROD_PLAN WHERE ".$where2." GROUP BY TGL) plan_coal,
        ROUND(SUM(ob)/(SELECT SUM(ob) FROM pma_dailyprod_plan WHERE ".$where2." GROUP BY tgl) * 100,1) ach_ob,
        ROUND(SUM(coal)/(SELECT SUM(coal) FROM pma_dailyprod_plan WHERE ".$where2." GROUP BY tgl) * 100,1)  ach_coal,
        kodesite
        FROM pma_dailyprod_tc a
        WHERE ".$where1."
        GROUP BY kodesite, tgl";

        return collect(DB::select($subquery));
    }

    public function headings() : array
    {
        return ['Tanggal', 'OB Shift 1', 'OB Shift 2', 'Total OB', 'Plan OB', 'Coal Shift 1', 'Coal Shift 2', 'Total Coal', 'Plan Coal', 'Ach OB', 'Ach Coal', 'Kodesite' ];
    }
}
