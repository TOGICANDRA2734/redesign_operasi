<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Productivity;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('pilihBulan')) {
            $bulan = Carbon::createFromFormat('Y-m', request()->pilihBulan);
            $tanggal =  "tgl BETWEEN '" . date('Y-m-d', strtotime($bulan->startOfMonth()->copy())) . "' AND '" . date('Y-m-d', strtotime($bulan->endOfMonth()->copy())) . "'";
        } else {
            $bulan = Carbon::now();
            $tanggal =  "tgl=CURDATE()";
        }

        if ($request->has('kodesite') && $request->kodesite !== 'all') {
            $subquery = "SELECT     
            DATE_FORMAT(tgl, '%d-%m-%Y') tanggal,    
            nom_unit,
            b.namasite,
            pit,
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
            (SELECT dist FROM pma_dailyprod_pty X WHERE ".$tanggal." AND nom_unit=A.nom_unit AND dist IS NOT NULL AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty WHERE ".$tanggal." AND nom_unit=x.nom_unit) ORDER BY nom_unit DESC LIMIT 1) dist,
            (SELECT ket FROM pma_dailyprod_pty X WHERE ".$tanggal." AND nom_unit=A.nom_unit AND ket IS NOT NULL  AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty WHERE ".$tanggal." AND nom_unit=x.nom_unit) ORDER BY nom_unit DESC LIMIT 1) ket
            FROM pma_dailyprod_pty A
            JOIN site B
            ON A.kodesite = B.kodesite                
            JOIN plant_tipe_unit C
            ON LEFT(A.nom_unit,4)= C.kode                
            WHERE " . $tanggal . " AND del=0 AND C.gol_1='2' and a.kodesite='" . $request->kodesite . "'
            GROUP BY a.kodesite, nom_unit,TYPE
            ORDER BY b.id, tgl, nom_unit";
        } else {
            $subquery = "SELECT     
            DATE_FORMAT(tgl, '%d-%m-%Y') tanggal,    
            nom_unit,
            b.namasite,
            pit,
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
            (SELECT dist FROM pma_dailyprod_pty X WHERE tgl=A.tgl AND nom_unit=A.nom_unit AND dist IS NOT NULL AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty WHERE tgl=A.tgl AND nom_unit=x.nom_unit) ORDER BY nom_unit DESC LIMIT 1) dist,
            (SELECT ket FROM pma_dailyprod_pty X WHERE tgl=A.tgl AND nom_unit=A.nom_unit AND ket IS NOT NULL  AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty WHERE tgl=A.tgl AND nom_unit=x.nom_unit) ORDER BY nom_unit DESC LIMIT 1) ket
            FROM pma_dailyprod_pty A 
            JOIN site B
            ON A.kodesite = B.kodesite                
            JOIN plant_tipe_unit C
            ON LEFT(A.nom_unit,4)= C.kode                
            WHERE " . $tanggal . " AND del=0 AND C.gol_1='2'
            GROUP BY a.kodesite, nom_unit,TYPE
            ORDER BY b.id, tgl, nom_unit";
        }

        $data = collect(DB::select($subquery));

        $site = Site::where('status_website', 1)->get();

        if ($request->has('kodesite') || $request->has('pilihBulan')) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('productivity.index', compact('data', 'site'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Data Detail PTY
        $subquery = "SELECT     
        nom_unit,
        b.namasite,
        pit,
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
        JOIN plant_tipe_unit C
        ON LEFT(A.nom_unit,4)= C.kode                                      
        WHERE tgl=CURDATE() AND del=0 AND C.gol_1='2'
        GROUP BY a.kodesite, nom_unit,TYPE
        ORDER BY b.id, nom_unit";

        $dataPty = collect(DB::select($subquery));

        $dataNomUnit = DB::table('plant_hm')->join('plant_tipe_unit', DB::raw('LEFT(plant_hm.nom_unit, 4)'), '=', 'plant_tipe_unit.kode')->select(DB::raw('nom_unit'))->orderBy('nom_unit')->where('kodesite', '=', Auth::user()->kodesite)->where('gol_1', '=', '2')->orderBy('nom_unit')->get();
        $dataPit = DB::table('pma_dailyprod_pit')->select(DB::raw('ket, kodepit'))->orderBy('ket')->where('kodesite', '=', Auth::user()->kodesite)->get();
        $subquery = "SELECT SUM(pty) total_pty
        FROM pma_dailyprod_pty A 
        JOIN site B
        ON A.kodesite = B.kodesite       
        JOIN plant_tipe_unit C
        ON LEFT(A.nom_unit,4)= C.kode                                      
        WHERE tgl=CURDATE() AND del=0 AND C.gol_1='2'
        ORDER BY b.id, nom_unit";
        $totalDataPty = collect(DB::select($subquery));


        $waktu = Carbon::now()->timezone('Asia/kuala_lumpur')->format('H:i'); 

        return view('user.productivity.create', compact('dataPty', 'dataNomUnit', 'dataPit', 'waktu', 'totalDataPty'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
    }

    public function check(Request $request)
    {
        $data = DB::table('pma_dailyprod_pty')->where('tgl', '=', $request->tgl)->where('nom_unit', '=', $request->nom_unit)->where('kodesite', '=', $request->kodesite)->where('jam', '=', $request->jam)->count();
        if($data == 0){
            $request->validate([
                'tgl' => 'required',
                'nom_unit' => 'required',
                'jam' => 'required',
                'pty' => 'required',
                'dist' => 'required',
                'kodesite' => 'required',
                'pit' => 'required',
            ]);
    
            $record = Productivity::create([
                'tgl' => $request->tgl,
                'nom_unit' => $request->nom_unit,
                'type' => substr($request->nom_unit, 0, 4),
                'jam' => $request->jam,
                'pty' => $request->pty,
                'dist' => $request->dist,
                'ket' => strtoupper($request->ket),
                'kodesite' => $request->kodesite,
                'pit' => $request->pit,
                'admin' => Auth::user()->username,
                'time_admin' => Carbon::now(),
            ]);

            if($record){
                return redirect()->route('productivity.create')->with(['success' => 'Data Berhasil Ditambah!']);
            }
            else{
                return redirect()->route('productivity.create')->with(['error' => 'Data Gagal Ditambah!']);
            }
        } else {
            return redirect()->back();
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
