<?php

namespace App\Http\Controllers;

use App\Models\dataProd;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class dataProdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data =  DB::table('pma_dailyprod_tc')
        // ->select(DB::raw('pma_dailyprod_tc.id, pma_dailyprod_tc.tgl, pma_dailyprod_tc.ob act_ob, pma_dailyprod_tc.coal act_coal, pma_dailyprod_plan.ob plan_ob,  pma_dailyprod_plan.coal plan_coal'))
        // ->join('pma_dailyprod_plan', 'pma_dailyprod_tc.tgl', '=', 'pma_dailyprod_plan.tgl')
        // ->where('pma_dailyprod_tc.kodesite', '=', 'I')
        // ->groupBy('pma_dailyprod_tc.tgl')
        // ->get();
        
        $statusSite = Auth::user()->kodesite; 

        $subquery = "SELECT 
        IFNULL(B.id,0) id,
        A.TGL,
        C.namasite,
        A.ob OB_PLAN,
        A.coal COAL_PLAN,
        IFNULL(B.ob,0) OB_ACTUAL,
        IFNULL(B.coal,0) COAL_ACTUAL,
        IFNULL(B.status,0) status
        FROM pma_dailyprod_PLAN A
        LEFT JOIN (SELECT * FROM pma_dailyprod_TC WHERE tgl BETWEEN '2022-07-01' AND '2022-07-31' AND kodesite='".$statusSite."' GROUP BY tgl ORDER BY tgl) B
        ON A.tgl = B.tgl
        LEFT JOIN site C
        ON B.kodesite=C.kodesite
        WHERE A.tgl BETWEEN '2022-07-01' AND '2022-07-31' AND A.kodesite='".$statusSite."'
        GROUP BY a.tgl
        ORDER BY a.tgl";

        $data = collect(DB::select($subquery));

        $site = DB::table('site')->select('namasite')->where('kodesite', '=', Auth::user()->kodesite)->get();

        $begin = new DateTime(date('Y-m-01'));
        $end = new DateTime(date('Y-m-t'));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);


        return view('data-prod.index', compact('data', 'site', 'period'));
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
        
        return view('data-prod.create', compact('site'));
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

        return view('data-prod.create', compact('site', 'tgl', 'cuaca'));
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
            return redirect()->route('data-prod.index')->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('data-prod.index')->with(['error' => 'Data Gagal Ditambah!']);
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
        return view('data-prod.show');
    }

   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_detail($id)
    {
        return view('data-prod.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('pma_dailyprod_tc')->select()->where('id', '=', $id)->get();
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

        return view('data-prod.edit', compact('site', 'data', 'cuaca'));
    }

    public function edit_data($id, $tgl, $other)
    {   
        if($other == 1){
            return Redirect::route('data-prod.edit', $id);            
        } else {
            return Redirect::route('create_data.index', $tgl);
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
            'cuaca'      => $request->cuaca,
        ]);

        if($record){
            return redirect()->route('data-prod.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('data-prod.index')->with(['error' => 'Data Gagal Diupdate!']);
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

    public function report()
    {
        $subquery = "SELECT A.TGL,
        SUM(A.ob) OB_PLAN ,
        SUM(A.coal) COAL_PLAN,
        SUM(IFNULL(B.ob,0)) OB_ACTUAL,
        SUM(IFNULL(B.coal,0)) COAL_ACTUAL
        FROM pma_dailyprod_PLAN A
        LEFT JOIN (SELECT * FROM pma_dailyprod_TC WHERE tgl BETWEEN '2022-07-01' AND '2022-07-31' GROUP BY tgl) B
        ON A.tgl = B.tgl
        WHERE A.tgl BETWEEN '2022-07-01' AND '2022-07-31'
        GROUP BY A.tgl";

        $data = collect(DB::select($subquery));

        return view('data-prod.report', compact('data'));
    }
}