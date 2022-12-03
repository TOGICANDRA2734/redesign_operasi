<?php

namespace App\Http\Controllers;

use App\Imports\ProductivityCoalImport;
use App\Models\ProductivityCoal;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ProductivityCoalController extends Controller
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
            // Where 1
            $where .= ($request->has('start') && $request->has('end')) ? "TGL BETWEEN '" . $request->start . "' AND '" . $request->end . "' " : "";
            $where .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? " AND " : "";
            $where .= ($request->has('pilihSite') && !empty($request->pilihSite)) ? "a.kodesite='" . $request->pilihSite . "'" : "";
            $where .= " AND DEL=0 ";

        } else {
            $where .= "TGL BETWEEN '" . Carbon::now()->startOfMonth() . "' AND '" . Carbon::now()->endOfMonth() . "' AND DEL=0";
        }

        if ($request->has('kodesite') && $request->kodesite !== 'all') {
            $subquery = "SELECT A.id,
            DATE_FORMAT(tgl, \"%d-%m-%Y\") tanggal,    
            b.namasite namasite,
            pit,
            ROUND(AVG(rit), 1) avg_rit,                                                        
            IFNULL(SUM(CASE WHEN jam = 0 THEN rit END),'-') j1,                    
            IFNULL(SUM(CASE WHEN jam = 1 THEN rit END),'-') j2,                    
            IFNULL(SUM(CASE WHEN jam = 2 THEN rit END),'-') j3,                    
            IFNULL(SUM(CASE WHEN jam = 3 THEN rit END),'-') j4,                    
            IFNULL(SUM(CASE WHEN jam = 4 THEN rit END),'-') j5,                    
            IFNULL(SUM(CASE WHEN jam = 5 THEN rit END),'-') j6,                    
            IFNULL(SUM(CASE WHEN jam = 6 THEN rit END),'-') j7,                    
            IFNULL(SUM(CASE WHEN jam = 7 THEN rit END),'-') j8,                    
            IFNULL(SUM(CASE WHEN jam = 8 THEN rit END),'-') j9,                          
            IFNULL(SUM(CASE WHEN jam = 9 THEN rit END),'-') j10,                    
            IFNULL(SUM(CASE WHEN jam = 10 THEN rit END),'-') j11,                          
            IFNULL(SUM(CASE WHEN jam = 11 THEN rit END),'-') j12,                    
            IFNULL(SUM(CASE WHEN jam = 12 THEN rit END),'-') j13,                          
            IFNULL(SUM(CASE WHEN jam = 13 THEN rit END),'-') j14,                    
            IFNULL(SUM(CASE WHEN jam = 14 THEN rit END),'-') j15,                          
            IFNULL(SUM(CASE WHEN jam = 15 THEN rit END),'-') j16,                    
            IFNULL(SUM(CASE WHEN jam = 16 THEN rit END),'-') j17,                          
            IFNULL(SUM(CASE WHEN jam = 17 THEN rit END),'-') j18,                    
            IFNULL(SUM(CASE WHEN jam = 18 THEN rit END),'-') j19,                          
            IFNULL(SUM(CASE WHEN jam = 19 THEN rit END),'-') j20,
            IFNULL(SUM(CASE WHEN jam = 20 THEN rit END),'-') j21,
            IFNULL(SUM(CASE WHEN jam = 21 THEN rit END),'-') j22,
            IFNULL(SUM(CASE WHEN jam = 22 THEN rit END),'-') j23,
            IFNULL(SUM(CASE WHEN jam = 23 THEN rit END),'-') j24,
            IFNULL((SELECT ket FROM pma_dailyprod_pty_coal X WHERE ket IS NOT NULL AND tgl=A.tgl AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty_coal WHERE tgl=A.tgl) LIMIT 1), '-') ket
            FROM pma_dailyprod_pty_coal A 
            JOIN site B
            ON A.kodesite = B.kodesite              
            WHERE " . $where . " 
            GROUP BY a.kodesite
            ORDER BY b.id";
        } else {
            $subquery = "SELECT A.id,
            DATE_FORMAT(tgl, \"%d-%m-%Y\") tanggal,    
            b.namasite,
            pit,
            ROUND(AVG(rit), 1) avg_rit,                                                               
            IFNULL(SUM(CASE WHEN jam = 0 THEN rit END),'-') j1,                    
            IFNULL(SUM(CASE WHEN jam = 1 THEN rit END),'-') j2,                    
            IFNULL(SUM(CASE WHEN jam = 2 THEN rit END),'-') j3,                    
            IFNULL(SUM(CASE WHEN jam = 3 THEN rit END),'-') j4,                    
            IFNULL(SUM(CASE WHEN jam = 4 THEN rit END),'-') j5,                    
            IFNULL(SUM(CASE WHEN jam = 5 THEN rit END),'-') j6,                    
            IFNULL(SUM(CASE WHEN jam = 6 THEN rit END),'-') j7,                    
            IFNULL(SUM(CASE WHEN jam = 7 THEN rit END),'-') j8,                    
            IFNULL(SUM(CASE WHEN jam = 8 THEN rit END),'-') j9,                          
            IFNULL(SUM(CASE WHEN jam = 9 THEN rit END),'-') j10,                    
            IFNULL(SUM(CASE WHEN jam = 10 THEN rit END),'-') j11,                          
            IFNULL(SUM(CASE WHEN jam = 11 THEN rit END),'-') j12,                    
            IFNULL(SUM(CASE WHEN jam = 12 THEN rit END),'-') j13,                          
            IFNULL(SUM(CASE WHEN jam = 13 THEN rit END),'-') j14,                    
            IFNULL(SUM(CASE WHEN jam = 14 THEN rit END),'-') j15,                          
            IFNULL(SUM(CASE WHEN jam = 15 THEN rit END),'-') j16,                    
            IFNULL(SUM(CASE WHEN jam = 16 THEN rit END),'-') j17,                          
            IFNULL(SUM(CASE WHEN jam = 17 THEN rit END),'-') j18,                    
            IFNULL(SUM(CASE WHEN jam = 18 THEN rit END),'-') j19,                          
            IFNULL(SUM(CASE WHEN jam = 19 THEN rit END),'-') j20,
            IFNULL(SUM(CASE WHEN jam = 20 THEN rit END),'-') j21,
            IFNULL(SUM(CASE WHEN jam = 21 THEN rit END),'-') j22,
            IFNULL(SUM(CASE WHEN jam = 22 THEN rit END),'-') j23,
            IFNULL(SUM(CASE WHEN jam = 23 THEN rit END),'-') j24,
            IFNULL((SELECT ket FROM pma_dailyprod_pty_coal X WHERE ket IS NOT NULL AND tgl=A.tgl AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty_coal WHERE tgl=A.tgl) LIMIT 1), '-') ket
            FROM pma_dailyprod_pty_coal A 
            JOIN site B
            ON A.kodesite = B.kodesite                                             
            WHERE " . $where . " 
            GROUP BY a.pit
            ORDER BY b.id";
        }

        $data = collect(DB::select($subquery));
        $site = Site::where('status_website', 1)->get();

        if (count($request->all()) > 1) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('productivity_coal.index', compact('data', 'site'));
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
        $subquery = "SELECT A.id,
        b.namasite,
        pit,
        ROUND(AVG(rit), 1) avg_rit,                                                               
            IFNULL(SUM(CASE WHEN jam = 0 THEN rit END),'-') j1,                    
            IFNULL(SUM(CASE WHEN jam = 1 THEN rit END),'-') j2,                    
            IFNULL(SUM(CASE WHEN jam = 2 THEN rit END),'-') j3,                    
            IFNULL(SUM(CASE WHEN jam = 3 THEN rit END),'-') j4,                    
            IFNULL(SUM(CASE WHEN jam = 4 THEN rit END),'-') j5,                    
            IFNULL(SUM(CASE WHEN jam = 5 THEN rit END),'-') j6,                    
            IFNULL(SUM(CASE WHEN jam = 6 THEN rit END),'-') j7,                    
            IFNULL(SUM(CASE WHEN jam = 7 THEN rit END),'-') j8,                    
            IFNULL(SUM(CASE WHEN jam = 8 THEN rit END),'-') j9,                          
            IFNULL(SUM(CASE WHEN jam = 9 THEN rit END),'-') j10,                    
            IFNULL(SUM(CASE WHEN jam = 10 THEN rit END),'-') j11,                          
            IFNULL(SUM(CASE WHEN jam = 11 THEN rit END),'-') j12,                    
            IFNULL(SUM(CASE WHEN jam = 12 THEN rit END),'-') j13,                          
            IFNULL(SUM(CASE WHEN jam = 13 THEN rit END),'-') j14,                    
            IFNULL(SUM(CASE WHEN jam = 14 THEN rit END),'-') j15,                          
            IFNULL(SUM(CASE WHEN jam = 15 THEN rit END),'-') j16,                    
            IFNULL(SUM(CASE WHEN jam = 16 THEN rit END),'-') j17,                          
            IFNULL(SUM(CASE WHEN jam = 17 THEN rit END),'-') j18,                    
            IFNULL(SUM(CASE WHEN jam = 18 THEN rit END),'-') j19,                          
            IFNULL(SUM(CASE WHEN jam = 19 THEN rit END),'-') j20,
            IFNULL(SUM(CASE WHEN jam = 20 THEN rit END),'-') j21,
            IFNULL(SUM(CASE WHEN jam = 21 THEN rit END),'-') j22,
            IFNULL(SUM(CASE WHEN jam = 22 THEN rit END),'-') j23,
            IFNULL(SUM(CASE WHEN jam = 23 THEN rit END),'-') j24,
        IFNULL((SELECT ket FROM pma_dailyprod_pty_coal X WHERE ket IS NOT NULL AND tgl=CURDATE() AND del=0 AND jam=(SELECT MAX(jam) FROM pma_dailyprod_pty_coal WHERE tgl=CURDATE()) LIMIT 1), '-') ket
        FROM pma_dailyprod_pty_coal A 
        JOIN site B
        ON A.kodesite = B.kodesite                                             
        WHERE tgl=CURDATE() AND del=0 and a.kodesite='" . Auth::user()->kodesite . "'
        GROUP BY a.kodesite
        ORDER BY b.id";

        $dataCoal = collect(DB::select($subquery));

        $dataPit = DB::table('pma_dailyprod_pit')->select(DB::raw('ket, kodepit'))->orderBy('ket')->where('kodesite', '=', Auth::user()->kodesite)->get();

        $subquery = "SELECT SUM(rit) total_rit
        FROM pma_dailyprod_pty_coal A 
        JOIN site B
        ON A.kodesite = B.kodesite                                             
        WHERE tgl=CURDATE() AND del=0 and a.kodesite='" . Auth::user()->kodesite . "'
        ORDER BY b.id";
        $totalDataCoal = collect(DB::select($subquery));

        $waktu = Carbon::now()->format('H:i');

        return view('productivity_coal.create', compact('dataCoal', 'dataPit', 'waktu', 'totalDataCoal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
    }

    public function check(Request $request)
    {

        $data = DB::table('pma_dailyprod_pty_coal')->where('tgl', '=', $request->tgl)->where('kodesite', '=', $request->kodesite)->where('jam', '=', $request->jam)->count();
        if ($data == 0) {
            $request->validate([
                'tgl' => 'required',
                'jam' => 'required',
                'rit' => 'required',
                'kodesite' => 'required',
                'pit' => 'required',
            ]);

            $record = ProductivityCoal::create([
                'tgl' => $request->tgl,
                'jam' => $request->jam,
                'rit' => $request->rit,
                'ket' => strtoupper($request->ket),
                'kodesite' => $request->kodesite,
                'pit' => $request->pit,
                'admin' => Auth::user()->username,
                'time_admin' => Carbon::now(),
            ]);

            if ($record) {
                return redirect()->route('productivity_coal.create')->with(['success' => 'Data Berhasil Ditambah!']);
            } else {
                return redirect()->route('productivity_coal.create')->with(['error' => 'Data Gagal Ditambah!']);
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
        $data = DB::table('pma_dailyprod_pty_coal')->select()->where('id', '=', $id)->get();
        $dataPit = DB::table('pma_dailyprod_pit')->select(DB::raw('ket, kodepit'))->orderBy('ket')->where('kodesite', '=', $data[0]->kodesite)->get();
        $countAll = DB::table('pma_dailyprod_pty_coal')->select(DB::raw('count(id) total_data'))->where('tgl', '=', $data[0]->tgl)->get();
        $data = DB::table('pma_dailyprod_pty_coal')->select(DB::raw('id, jam, rit, ket, pit'))->where('tgl', '=', $data[0]->tgl)->get();

        // dd($data, $dataPit, $countAll);

        return view('productivity_coal.edit', compact('data', 'dataPit', 'countAll'));
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
        for ($i = 0; $i < $request->total; $i++) {
            $id = $request['id_' . $i];
            $data = ProductivityCoal::findOrFail($id);

            $data->update([
                'rit' => $request['rit_' . $i],
                'ket' => $request['remarks_' . $i],
                'pit' => $request['pit_' . $i],
            ]);
        }

        if ($data) {
            return redirect()->route('super_admin.productivity_coal.create')->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            return redirect()->route('super_admin.productivity_coal.create')->with(['error' => 'Data Gagal Diubah!']);
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
    

    public function import_excel(Request $request)
    {
        // validasi
		$this->validate($request, [
			'excel' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('excel');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_productivity_coal',$nama_file);
 
		// import data
		Excel::import(new ProductivityCoalImport, public_path('/file_productivity_coal/'.$nama_file));
 
		// notifikasi dengan session
		Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		return redirect()->back()->with(['success' => 'Data Berhasil Diimport!']);;
    }
}
