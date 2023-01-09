<?php

namespace App\Exports;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanProduksiExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;        
    }

    public function collection()
    {
        $where = '';

        if (count($this->data->all()) > 1) {              
            // Where 1
            $where .= ($this->data->has('start') && $this->data->has('end')) ? "TGL BETWEEN '" . $this->data->start . "' AND '" . $this->data->end . "' " : "";
            $where .= ($this->data->has('kodesite') && !empty($this->data->kodesite)) ? " AND " : "";
            $where .= ($this->data->has('kodesite') && !empty($this->data->kodesite)) ? "kodesite='" . $this->data->kodesite . "'" : "";
        } else {
            $where .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "'";
        }

        if($this->data->has('kodesite') && $this->data->kodesite !== 'all'){
            $subquery = "SELECT tgl tgl_data,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN ob END),1),'-') AS ob_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN ob END),1),'-') AS ob_2,
            IFNULL(ROUND(SUM(OB),1),'-') AS sum_ob,
            (SELECT SUM(OB) FROM PMA_DAILYPROD_PLAN WHERE TGL=TGL_DATA AND kodesite='".$this->data->kodesite."' GROUP BY TGL) plan_ob,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN coal END),1),'-') AS coal_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN coal END),1),'-') AS coal_2,
            IFNULL(ROUND(SUM(coal),1),'-') AS sum_coal,
            (SELECT SUM(coal) FROM PMA_DAILYPROD_PLAN WHERE TGL=TGL_DATA AND kodesite='".$this->data->kodesite."' GROUP BY TGL) plan_coal,
            ROUND(SUM(ob)/(SELECT SUM(ob) FROM pma_dailyprod_plan WHERE tgl=tgl_data AND kodesite='".$this->data->kodesite."' GROUP BY tgl) * 100,1) ach_ob,
            ROUND(SUM(coal)/(SELECT SUM(coal) FROM pma_dailyprod_plan WHERE tgl=tgl_data AND kodesite='".$this->data->kodesite."' GROUP BY tgl) * 100,1)  ach_coal
            FROM pma_dailyprod_tc
            WHERE ".$where."
            GROUP BY tgl";
        } else {
            $subquery = "SELECT tgl tgl_data,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN ob END),1),'-') AS ob_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN ob END),1),'-') AS ob_2,
            IFNULL(ROUND(SUM(OB),1),'-') AS sum_ob,
            (SELECT SUM(OB) FROM PMA_DAILYPROD_PLAN WHERE TGL=TGL_DATA GROUP BY TGL) plan_ob,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN coal END),1),'-') AS coal_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN coal END),1),'-') AS coal_2,
            IFNULL(ROUND(SUM(coal),1),'-') AS sum_coal,
            (SELECT SUM(coal) FROM PMA_DAILYPROD_PLAN WHERE TGL=TGL_DATA GROUP BY TGL) plan_coal,
            ROUND(SUM(ob)/(SELECT SUM(ob) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1) ach_ob,
            ROUND(SUM(coal)/(SELECT SUM(coal) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1)  ach_coal
            FROM pma_dailyprod_tc
            WHERE ".$where."
            GROUP BY tgl";
        }


        return collect(DB::select($subquery));
    }

    public function headings() : array
    {
        return ['Tanggal', 'OB Shift 1', 'OB Shift 1', 'Total OB', 'Plan OB', 'Coal Shift 1', 'Coal Shift 2', 'Total Coal', 'Plan Coal', 'Ach OB', 'Ach Coal' ];
    }
}
