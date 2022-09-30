<?php

namespace App\Http\Controllers;

use App\Imports\KendalaImport;
use App\Models\Kendala;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class KendalaController extends Controller
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
            $subquery = "SELECT *
            FROM pma_dailyprod_kendala
            WHERE ".$tanggal." AND kodesite='".$request->kodesite."' 
            ORDER BY tgl DESC";
        } else {
            $subquery = "SELECT *
            FROM pma_dailyprod_kendala
            WHERE ".$tanggal."
            ORDER BY tgl DESC";
        }

        $data = collect(DB::select($subquery));

        $site = Site::where('status_website', 1)->get();
        $waktu = Carbon::now();

        if  ($request->has('kodesite') || $request->has('pilihBulan')) {
            $response['data'] = $data;
            return response()->json($response);
        } else {
            return view('kendala.index', compact('data', 'site', 'waktu'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $site = DB::table('site')->select('kodesite', 'namasite')->where('kodesite', '=', Auth::user()->kodesite)->get();
        $unit = DB::table('plant_hm')->select('nom_unit')->where('kodesite', '=', Auth::user()->kodesite)->orderBy('nom_unit')->get();
        $waktu = Carbon::now()->format('Y-m-d');
        $kendala_code  = DB::table('kendala_status')->select('status','kode')->where('del','=',0)->get();
        
        return view('kendala.create', compact('site', 'unit', 'waktu', 'kendala_code'));
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
            'tgl' => 'required',
            'unit' => 'required',
            'shift' => 'required',
            'awal' => 'required',
            'akhir' => 'required',
            'ket' => 'required',
            'kodesite' => 'required',
        ]);

        $record = Kendala::create([
            'tgl' => $request->tgl,
            'unit' => $request->unit,
            'shift' => $request->shift,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'ket' => strtoupper($request->ket),
            'kodesite' => $request->kodesite,
        ]);

        if($record){
            return redirect()->route('kendala.index')->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('kendala.index')->with(['error' => 'Data Gagal Ditambah!']);
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
        $data = Kendala::findOrFail($id);
        $site = DB::table('site')->select('kodesite', 'namasite')->where('kodesite', '=', Auth::user()->kodesite)->get();
        $unit = DB::table('plant_hm')->select('nom_unit')->where('kodesite', '=', Auth::user()->kodesite)->orderBy('nom_unit')->get();
        return view('kendala.edit', compact('data','site', 'unit'));
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
            'tgl' => 'required',
            'unit' => 'required',
            'shift' => 'required',
            'awal' => 'required',
            'akhir' => 'required',
            'ket' => 'required',
            'kodesite' => 'required',
        ]);

        $record = Kendala::findOrFail($id);

        $record->update([
            'tgl' => $request->tgl,
            'unit' => $request->unit,
            'shift' => $request->shift,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'ket' => strtoupper($request->ket),
            'kodesite' => $request->kodesite,
        ]);

        if($record){
            return redirect()->route('kendala.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('kendala.index')->with(['error' => 'Data Gagal Diupdate!']);
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
		$file->move('file_kendala',$nama_file);
 
		// import data
		Excel::import(new KendalaImport, public_path('/file_kendala/'.$nama_file));
 
		// notifikasi dengan session
		Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
		// alihkan halaman kembali
		return redirect()->back();
    }
}
