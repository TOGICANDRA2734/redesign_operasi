<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\dataProd;
use App\Models\Site;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use function PHPUnit\Framework\isNull;

class dataProdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bulan = Carbon::now();
        $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy() . "'";

        if(strtolower(Auth::user()->kodesite) === 'x'){
            $site = DB::table('site')->select('namasite', 'kodesite')->where('status_website', '=', 1)->get();
            $userSite = 'I';

            $subquery = "SELECT id,
            IFNULL(SUM(CASE WHEN shift = 1 THEN ob END),0) ob_s1, 
            IFNULL(SUM(CASE WHEN shift = 2 THEN ob END),0) ob_s2, 
            IFNULL(SUM(CASE WHEN shift = 1 THEN coal END),0) coal_s1, 
            IFNULL(SUM(CASE WHEN shift = 2 THEN coal END),0) coal_s2
            FROM pma_dailyprod_tc
            WHERE ".$tanggal." and kodesite='".$userSite."' 
            GROUP BY tgl, kodesite";
        } else {
            $userSite = Auth::user()->kodesite;

            $site = DB::table('site')->select('namasite', 'kodesite')->where('kodesite', '=', $userSite)->get();
            $subquery = "SELECT id,
            IFNULL(SUM(CASE WHEN shift = 1 THEN ob END),0) ob_s1, 
            IFNULL(SUM(CASE WHEN shift = 2 THEN ob END),0) ob_s2, 
            IFNULL(SUM(CASE WHEN shift = 1 THEN coal END),0) coal_s1, 
            IFNULL(SUM(CASE WHEN shift = 2 THEN coal END),0) coal_s2
            FROM pma_dailyprod_tc
            WHERE ".$tanggal." and kodesite='".$userSite."' 
            GROUP BY tgl";
        }

        $data = collect(DB::select($subquery));

        $begin = new DateTime( Carbon::now()->startOfMonth() );
        $end   = new DateTime( Carbon::now()->endOfMonth() );
        $period = [];

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $period[] = $i->format("Y-m-d");
        }

        $userSite = DB::table('site')->select('namasite')->where('kodesite', '=', $userSite)->get();

        return view('admin.data-prod.index', compact('data', 'site', 'period', 'userSite'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $site = DB::table('site')
        ->select()
        ->where('status_website', '=', 1)
        ->where('status', '=', 1)
        ->orderBy('id')
        ->get();
        
        return view('admin.data-prod.create', compact('site'));
    }

    public function create_data($tgl)
    {
        $site = DB::table('site')
        ->select()
        ->where('status_website', '=', 1)
        ->where('status', '=', 1)
        ->where('kodesite', '=', Auth::user()->kodesite)
        ->orderBy('id')
        ->get();

        $tgl = $tgl;

        $cuaca = DB::table('pma_dailyprod_cuacaicon')
        ->select()
        ->where('del', '=', 0)
        ->get(); 

        return view('admin.data-prod.create', compact('site', 'tgl', 'cuaca'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pit' => 'required',
            'ob' => 'required',
            'coal' => 'required',
            'kodesite' => 'required',
            'cuaca' => 'required',
        ]);

        $record = dataProd::create([
            'tgl'           => $request->tgl,
            'pit'           => $request->pit,
            'ob'            => $request->ob,
            'coal'          => $request->coal,
            'kodesite'      => $request->kodesite,
            'cuaca'         => $request->cuaca,
            'status'        => 1,
        ]);

        if($record){
            return redirect()->route('admin.data-prod.index')->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('admin.data-prod.index')->with(['error' => 'Data Gagal Ditambah!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.data-prod.show');
    }

   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_detail($id)
    {
        return view('admin.data-prod.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('pma_dailyprod_tc')->select()->where('tgl', '=', $id)->where('kodesite', '=', Auth::user()->kodesite)->groupBy('pit')->orderBy('pit')->first();
        
        $site = DB::table('site')
        ->select()
        ->where('status_website', '=', 1)
        ->where('status', '=', 1)
        ->where('kodesite', '=', Auth::user()->kodesite)
        ->orderBy('id')
        ->get();
        
        $cuaca = DB::table('pma_dailyprod_cuacaicon')
        ->select()
        ->where('del', '=', 0)
        ->get(); 

        $subquery = "SELECT pit,
        SUM(CASE WHEN shift = 1 THEN ob END) ob_1,
        SUM(CASE WHEN shift = 1 THEN coal END) coal_1,
        SUM(CASE WHEN shift = 2 THEN ob END) ob_2,
        SUM(CASE WHEN shift = 2 THEN coal END) coal_2
        FROM pma_dailyprod_tc
        WHERE tgl='".$id."' AND kodesite='".Auth::user()->kodesite."'
        GROUP BY pit
        ";
        $dataProd = collect(DB::select($subquery));

        return view('admin.data-prod.edit', compact('site', 'data', 'cuaca', 'dataProd'));
    }

    public function edit_data($id, $tgl, $other)
    {   
        if($other == 1){
            return Redirect::route('admin.data-prod.edit', $id);            
        } else {
            return Redirect::route('admin.create_data.index', $tgl);
        }
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
        $request->validate([
            'pit' => 'required',
            'ob' => 'required',
            'coal' => 'required',
            'kodesite' => 'required',
            'cuaca' => 'required',
        ]);

        $record = dataProd::findOrFail($id);
        
        $record->update([
            'tgl'           => $request->tgl,
            'pit'           => $request->pit,
            'ob'            => $request->ob,
            'coal'          => $request->coal,
            'kodesite'      => $request->kodesite,
            'cuaca'         => $request->cuaca,
        ]);

        if($record){
            return redirect()->route('admin.data-prod.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('admin.data-prod.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function update_data(Request $request, $id)
    {   
        $request->validate([
            'pit_0' => 'required',
            'ob_1_0' => 'required',
            'coal_1_0' => 'required',
            'ob_2_0' => 'required',
            'coal_2_0' => 'required',
            'kodesite' => 'required',
            'cuaca' => 'required',
        ]);

        // Record Pit
        $pit = DB::table('pma_dailyprod_tc')->select(DB::raw('DISTINCT pit'))->where('kodesite', '=',Auth::user()->kodesite)->orderBy('pit')->get();
        
        foreach($pit as $key => $pt){
            $record = dataProd::all()->where('kodesite', '=', $request->kodesite)->where('pit',  '=',$pt->pit)->where('tgl', '=', $request->tgl);
            
            foreach($record as $r)
            {   
                $data = dataProd::findOrFail($r->id);
                if($data->shift == 1){
                    $data->update([
                        'tgl'               => $request->tgl,
                        'pit'               => $pt->pit,
                        'ob'                => $request->{"ob_1_".$key.""},
                        'coal'              => $request->{"coal_1_".$key.""},
                        'shift'             => 1,
                        'kodesite'          => $request->kodesite,
                        'cuaca'             => $request->cuaca,
                    ]);
                    
                } else {
                    $data->update([
                        'tgl'               => $request->tgl,
                        'pit'               => $pt->pit,
                        'ob'                => $request->{"ob_2_".$key.""},
                        'coal'              => $request->{"coal_2_".$key.""},
                        'shift'             => 2,
                        'kodesite'          => $request->kodesite,
                        'cuaca'             => $request->cuaca,
                    ]);
                }
            }
        }
        

        if($record){
            return redirect()->route('admin.data-prod.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('admin.data-prod.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
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


    /**
     * Give new data pit based on site
     * 
     * @param varchar $kodesite
     */
    public function getPit(Request $request)
    {
        if ($request->kodesite) {
            $response = DB::table('pma_dailyprod_pit')
            ->select('kodepit', 'ket')
            ->where('kodesite', '=', $request->kodesite)
            ->where('status', '=', 1)
            ->get();
            if ($response) {
                return response()->json(['status' => 'success', 'data' => $response], 200);
            }
            return response()->json(['status' => 'failed', 'message' => 'No frameworks found'], 404);
        }
        return response()->json(['status' => 'failed', 'message' => 'Please select language'], 500);
    }

    public function report(Request $request)
    {
        // dd($request);

        $bulan = Carbon::now();
        $tanggal =  "tgl BETWEEN '" . date('Y-m-d', strtotime($bulan->startOfMonth()->copy())) . "' AND '" . date('Y-m-d', strtotime($bulan->endOfMonth()->copy())) . "'";

        if($request->has('kodesite')){
            $subquery = "SELECT tgl tgl_data,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN ob END),1),'-') AS ob_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN coal END),1),'-') AS coal_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN ob END),1),'-') AS ob_2,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN coal END),1),'-') AS coal_2,
            ROUND(SUM(ob)/(SELECT SUM(ob) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1) ach_ob,
            ROUND(SUM(coal)/(SELECT SUM(coal) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1)  ach_coal
            FROM pma_dailyprod_tc
            WHERE ".$tanggal." and kodesite='".$request->kodesite."'
            GROUP BY tgl";
        } else {
            $subquery = "SELECT tgl tgl_data,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN ob END),1),'-') AS ob_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN coal END),1),'-') AS coal_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN ob END),1),'-') AS ob_2,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN coal END),1),'-') AS coal_2,
            ROUND(SUM(ob)/(SELECT SUM(ob) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1) ach_ob,
            ROUND(SUM(coal)/(SELECT SUM(coal) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1)  ach_coal
            FROM pma_dailyprod_tc
            WHERE ".$tanggal."
            GROUP BY tgl";
        }

        $data = collect(DB::select($subquery));

        $site = Site::select('namasite', 'lokasi', 'kodesite')->where('status_website', 1)->get();

        if($request->has('kodesite')){
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('admin.data-prod.report', compact('data', 'site'));
        }
    }
    
    public function switch_site(Request $request)
    {
        // dd($request);

        $bulan = Carbon::now();
        $tanggal =  "tgl BETWEEN '" . date('Y-m-d', strtotime($bulan->startOfMonth()->copy())) . "' AND '" . date('Y-m-d', strtotime($bulan->endOfMonth()->copy())) . "'";

        if($request->has('kodesite')){
            $subquery = "SELECT tgl tgl_data,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN ob END),1),'-') AS ob_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN coal END),1),'-') AS coal_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN ob END),1),'-') AS ob_2,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN coal END),1),'-') AS coal_2,
            ROUND(SUM(ob)/(SELECT SUM(ob) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1) ach_ob,
            ROUND(SUM(coal)/(SELECT SUM(coal) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1)  ach_coal
            FROM pma_dailyprod_tc
            WHERE ".$tanggal." and kodesite='".$request->kodesite."'
            GROUP BY tgl";
        } else {
            $subquery = "SELECT tgl tgl_data,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN ob END),1),'-') AS ob_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 1 THEN coal END),1),'-') AS coal_1,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN ob END),1),'-') AS ob_2,
            IFNULL(ROUND(SUM(CASE WHEN shift = 2 THEN coal END),1),'-') AS coal_2,
            ROUND(SUM(ob)/(SELECT SUM(ob) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1) ach_ob,
            ROUND(SUM(coal)/(SELECT SUM(coal) FROM pma_dailyprod_plan WHERE tgl=tgl_data GROUP BY tgl) * 100,1)  ach_coal
            FROM pma_dailyprod_tc
            WHERE ".$tanggal."
            GROUP BY tgl";
        }

        $data = collect(DB::select($subquery));

        $site = Site::select('namasite', 'lokasi', 'kodesite')->where('status_website', 1)->get();

        if($request->has('kodesite')){
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('data-prod.report', compact('data', 'site'));
        }
    }
}